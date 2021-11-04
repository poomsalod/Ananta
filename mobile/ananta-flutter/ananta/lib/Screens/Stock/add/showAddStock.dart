import 'package:ananta/Model/cate_igd.dart';
import 'package:ananta/Model/igd_for_allergy.dart';
import 'package:ananta/Screens/Stock/add/addStock.dart';
import 'package:ananta/Services/auth.dart';
import 'package:ananta/Services/food_allergy.dart';
import 'package:ananta/Services/stock.dart';
import 'package:ananta/components/card_addFoodAllergy.dart';
import 'package:ananta/components/search.dart';
import 'package:ananta/constants.dart';
import 'package:flutter/material.dart';
import 'package:flutter_secure_storage/flutter_secure_storage.dart';
import 'package:provider/provider.dart';

class ShowAddStockScreen extends StatefulWidget {
  const ShowAddStockScreen({Key? key}) : super(key: key);

  @override
  _ShowAddStockScreenState createState() => _ShowAddStockScreenState();
}

class _ShowAddStockScreenState extends State<ShowAddStockScreen> {
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
      Provider.of<Stock>(context, listen: false)
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
        child: Center(child: Consumer<Stock>(builder: (context, stock, child) {
          if (stock.igd.length != 0) {
            List<String> nameCate = [];
            List<int> idCate = [];
            for (int i = 0; i < stock.orderCateIgd.length; i++) {
              CateIgdModel cateFood = stock.orderCateIgd[i];
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
                  'เพิ่มวัตถุดิบในคลัง',
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
                        IgdModal data = stock.igd[index];
                        dataMax = stock.igd.length;
                        if (chackSearch == 1) {
                          data = dataSearch[index];
                          dataMax = dataSearch.length;
                        }

                        int igdId = data.igdInfoId;

                        String imageUrl = baseUrlImage + 'igd/' + data.image;
                        return CardAddFoodAllergy(
                          name: data.name,
                          imageUrl: imageUrl,
                          textButton: 'เลือก',
                          colorButton: Colors.orange,
                          fn: () {
                            Navigator.push(
                              context,
                              MaterialPageRoute(
                                builder: (context) {
                                  return AddStockScreen(igdId: igdId);
                                },
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
        Provider.of<Stock>(context, listen: false).igd.where((element) {
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
          Provider.of<Stock>(context, listen: false).igd.where((element) {
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
          Provider.of<Stock>(context, listen: false).igd.where((element) {
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
