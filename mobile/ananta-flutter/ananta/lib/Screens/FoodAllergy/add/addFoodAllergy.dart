import 'package:ananta/Model/cate_igd.dart';
import 'package:ananta/Model/igd_for_allergy.dart';
import 'package:ananta/Services/auth.dart';
import 'package:ananta/Services/food_allergy.dart';
import 'package:ananta/components/card_addFoodAllergy.dart';
import 'package:ananta/components/search.dart';
import 'package:ananta/constants.dart';
import 'package:flutter/material.dart';
import 'package:flutter_secure_storage/flutter_secure_storage.dart';
import 'package:provider/provider.dart';

class AddFoodAllergyScreen extends StatefulWidget {
  const AddFoodAllergyScreen({Key? key}) : super(key: key);

  @override
  _AddFoodAllergyScreenState createState() => _AddFoodAllergyScreenState();
}

class _AddFoodAllergyScreenState extends State<AddFoodAllergyScreen> {
  final storage = new FlutterSecureStorage();
  ScrollController _scrollController = ScrollController();
  int _currentMax = 10;
  int dataMax = 0;

  //search
  List<IgdModal> dataSearch = [];
  int chackSearch = 0;
  String query = '';

  @override
  void initState() {
    super.initState();
    readToken();

    _scrollController.addListener(() {
      if (_scrollController.position.pixels ==
          _scrollController.position.maxScrollExtent) {
        _getMoreData();
      }
    });
  }

  Future<Null> readToken() async {
    final token = await storage.read(key: 'token');
    setState(() {
      print(token);
      int userId = Provider.of<Auth>(context, listen: false).profile.user_id;
      Provider.of<FoodAllergy>(context, listen: false)
          .fetchigd(token: token == null ? '' : token, userId: userId);
    });
  }

  Future<Null> addFoodAllergy(int igdId) async {
    final token = await storage.read(key: 'token');
    setState(() {
      print(token);
      int userId = Provider.of<Auth>(context, listen: false).profile.user_id;
      Provider.of<FoodAllergy>(context, listen: false).addFoodAllergy(
          token: token == null ? '' : token, userId: userId, igdId: igdId);
    });
  }

  _getMoreData() {
    if (_currentMax < dataMax) {
      if (dataMax - _currentMax < 10) {
        _currentMax = _currentMax + dataMax - _currentMax;
      } else {
        _currentMax = _currentMax + 10;
      }
    }
    setState(() {});
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Image.asset(
          'assets/images/logo_ananta.png',
          width: 80,
        ),
        flexibleSpace: Container(
          decoration: BoxDecoration(
            gradient: LinearGradient(
              colors: [Colors.orange, Colors.brown],
              begin: Alignment.bottomRight,
              end: Alignment.topLeft,
            ),
          ),
        ),
      ),
      body: SafeArea(
        child: Center(child:
            Consumer<FoodAllergy>(builder: (context, food_allergy, child) {
          if (food_allergy.igd.length != 0) {
            List<String> nameCate = [];
            List<int> idCate = [];
            for (int i = 0; i < food_allergy.orderCateIgd.length; i++) {
              CateIgdModel cateFood = food_allergy.orderCateIgd[i];
              nameCate.add(cateFood.name);
              idCate.add(cateFood.cateIgdId);
            }
            nameCate.add('ทั้งหมด');
            idCate.add(0);
            return Column(
              children: [
                SizedBox(
                  height: 5,
                ),
                Text(
                  'เพิ่มวัตถุดิบที่แพ้',
                  style: TextStyle(fontSize: 30),
                ),
                SizedBox(
                  height: 5,
                ),
                SearchWidget(
                  text: query,
                  onChangedFood: searchIgd,
                  onChangedCate: searchCate,
                  hintText: 'ค้นหา',
                  nameCate: nameCate,
                  idCate: idCate,
                ),
                Expanded(
                  child: ListView.builder(
                      controller: _scrollController,
                      itemCount: _currentMax,
                      itemBuilder: (context, int index) {
                        // if (index == _currentMax) {
                        //   return CupertinoActivityIndicator();
                        // }
                        IgdModal data = food_allergy.igd[index];
                        dataMax = food_allergy.igd.length;
                        if (chackSearch == 1) {
                          data = dataSearch[index];
                          dataMax = dataSearch.length;
                        }

                        int igdId = data.igdInfoId;

                        String imageUrl = baseUrlImage + 'igd/' + data.image;
                        return CardAddFoodAllergy(
                          name: data.name,
                          imageUrl: imageUrl,
                          textButton: 'เพิ่ม',
                          colorButton: Colors.orange,
                          fn: () {
                            showDialog(
                              context: context,
                              builder: (context) => AlertDialog(
                                title: Text('การยืนยัน'),
                                content: Column(
                                  mainAxisSize: MainAxisSize.min,
                                  children: [
                                    Text(
                                        'คุณต้องการเพิ่มวัตถุดิบนี้ใช่หรือไม่'),
                                  ],
                                ),
                                actions: [
                                  TextButton(
                                    onPressed: () {
                                      Navigator.pop(context);
                                      addFoodAllergy(igdId);
                                      final text = 'เพิ่มการแพ้อาหารเรียบร้อย';
                                      final snackBar =
                                          SnackBar(content: Text(text));

                                      ScaffoldMessenger.of(context)
                                          .showSnackBar(snackBar);
                                    },
                                    child: Text('ใช่'),
                                  ),
                                  TextButton(
                                    onPressed: () {
                                      Navigator.pop(context);
                                    },
                                    child: Text(
                                      'ไม่',
                                      style: TextStyle(color: Colors.red),
                                    ),
                                  )
                                ],
                              ),
                            );
                          },
                        );
                      }),
                ),
              ],
            );
          } else {
            return Center(child: CircularProgressIndicator());
          }
        })),
      ),
    );
  }

  void searchIgd(String query) {
    final allIgd =
        Provider.of<FoodAllergy>(context, listen: false).igd.where((element) {
      final nameLower = element.name.toLowerCase();
      final searchLower = query.toLowerCase();
      return nameLower.contains(searchLower);
    }).toList();

    setState(() {
      this.dataSearch = allIgd;
      this.query = query;
      this.chackSearch = 1;
      this._currentMax = allIgd.length;
    });
  }

  void searchCate(int query) {
    if (query == 0) {
      final allIgd =
          Provider.of<FoodAllergy>(context, listen: false).igd.where((element) {
        final nameLower = element.name.toLowerCase();
        final searchLower = "".toLowerCase();
        return nameLower.contains(searchLower);
      }).toList();
      setState(() {
        this.dataSearch = allIgd;
        this.query = '';
        this.chackSearch = 1;
        this._currentMax = allIgd.length;
      });
    } else {
      final allIgd =
          Provider.of<FoodAllergy>(context, listen: false).igd.where((element) {
        final cateNum = element.cateIgdId;
        final searchLower = query;
        return cateNum == searchLower;
      }).toList();
      setState(() {
        this.dataSearch = allIgd;
        this.query = '';
        this.chackSearch = 1;
        this._currentMax = allIgd.length;
      });
    }
  }
}
