import 'package:ananta/Model/cate_igd.dart';
import 'package:ananta/Model/igd_for_allergy.dart';
import 'package:ananta/Services/auth.dart';
import 'package:ananta/Services/food_allergy.dart';
import 'package:ananta/Services/stock.dart';
import 'package:ananta/components/card_addFoodAllergy.dart';
import 'package:ananta/components/card_addStock.dart';
import 'package:ananta/components/search.dart';
import 'package:ananta/constants.dart';
import 'package:flutter/material.dart';
import 'package:flutter_secure_storage/flutter_secure_storage.dart';
import 'package:provider/provider.dart';

class AddStockScreen extends StatefulWidget {
  final int igdId;
  const AddStockScreen({
    Key? key,
    required this.igdId,
  }) : super(key: key);

  @override
  _AddStockScreenState createState() => _AddStockScreenState(igdId: igdId);
}

class _AddStockScreenState extends State<AddStockScreen> {
  int igdId;
  _AddStockScreenState({
    required this.igdId,
  });

  TextEditingController _valueController = TextEditingController();
  final _formkey = GlobalKey<FormState>();
  final storage = new FlutterSecureStorage();

  List<IgdModal> dataSearch = [];
  int chackSearch = 0;

  @override
  void initState() {
    super.initState();

    searchIgd(igdId);
  }

  Future<Null> addStock(int igdId, String value) async {
    final token = await storage.read(key: 'token');
    setState(() {
      print(token);
      int userId = Provider.of<Auth>(context, listen: false).profile.user_id;
      Provider.of<Stock>(context, listen: false).addStock(
          token: token == null ? '' : token,
          igdId: igdId,
          userId: userId,
          value: value);
    });
  }

  void searchIgd(int igdId) {
    final allIgd =
        Provider.of<Stock>(context, listen: false).igd.where((element) {
      final igd = element.igdInfoId;
      final searchId = igdId;
      return igd == searchId;
    }).toList();

    setState(() {
      this.dataSearch = allIgd;
      this.chackSearch = 1;
    });
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
          if (dataSearch.length != 0) {
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
                Expanded(
                  child: ListView.builder(
                      itemCount: 1,
                      itemBuilder: (context, int index) {
                        // if (index == _currentMax) {
                        //   return CupertinoActivityIndicator();
                        // }
                        IgdModal data = stock.igd[index];
                        if (chackSearch == 1) {
                          data = dataSearch[index];
                        }

                        int igdId = data.igdInfoId;

                        String imageUrl = baseUrlImage + 'igd/' + data.image;
                        return Form(
                          key: _formkey,
                          child: CardAddStock(
                            name: data.name,
                            imageUrl: imageUrl,
                            textButton: 'เพิ่ม',
                            colorButton: Colors.orange,
                            fn: () {
                              if (_formkey.currentState!.validate()) {
                                _formkey.currentState!.save();
                                print(_valueController.text);
                                addStock(igdId, _valueController.text);
                                Navigator.pop(context);
                                final text = 'เพิ่มวัตถุดิบในคลังเรียบร้อย';
                                final snackBar = SnackBar(content: Text(text));

                                ScaffoldMessenger.of(context)
                                    .showSnackBar(snackBar);
                                _formkey.currentState!.reset();
                              }
                            },
                            controller: _valueController,
                          ),
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
}
