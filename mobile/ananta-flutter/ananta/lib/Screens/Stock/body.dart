import 'package:ananta/Model/stock.dart';
import 'package:ananta/Screens/Stock/add/showAddStock.dart';
import 'package:ananta/Services/auth.dart';
import 'package:ananta/Services/food_allergy.dart';
import 'package:ananta/Services/stock.dart';
import 'package:ananta/components/card_stock.dart';
import 'package:ananta/constants.dart';
import 'package:flutter/material.dart';
import 'package:flutter_secure_storage/flutter_secure_storage.dart';
import 'package:provider/provider.dart';

class Body extends StatefulWidget {
  const Body({Key? key}) : super(key: key);

  @override
  _BodyState createState() => _BodyState();
}

class _BodyState extends State<Body> {
  final storage = new FlutterSecureStorage();

  @override
  void initState() {
    super.initState();
    readToken();
  }

  Future<Null> readToken() async {
    final token = await storage.read(key: 'token');
    setState(() {
      print(token);
      int userId = Provider.of<Auth>(context, listen: false).profile.user_id;
      Provider.of<Stock>(context, listen: false)
          .fetchStock(token: token == null ? '' : token, userId: userId);
    });
  }

  Future<Null> deleteStock(int igdId) async {
    final token = await storage.read(key: 'token');
    setState(() {
      print(token);
      int userId = Provider.of<Auth>(context, listen: false).profile.user_id;
      Provider.of<Stock>(context, listen: false).deleteStock(
          token: token == null ? '' : token, userId: userId, igdId: igdId);
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
          if (stock.igdStock.length != 0) {
            return Column(
              children: [
                Padding(
                  padding: const EdgeInsets.all(8.0),
                  child: Row(
                    children: [
                      Text(
                        'รายการวัตถุดิบในคลัง',
                        style: TextStyle(fontSize: 20),
                      ),
                      SizedBox(
                        width: 10,
                      ),
                      Expanded(
                        child: ElevatedButton(
                          child: Text('เพิ่มวัตถุดิบในคลัง'),
                          style: ButtonStyle(
                            backgroundColor:
                                MaterialStateProperty.all<Color>(Colors.orange),
                          ),
                          onPressed: () {
                            Navigator.push(
                              context,
                              MaterialPageRoute(
                                builder: (context) {
                                  return ShowAddStockScreen();
                                },
                              ),
                            );
                          },
                        ),
                      ),
                    ],
                  ),
                ),
                Expanded(
                  child: ListView.builder(
                      itemCount: stock.igdStock.length,
                      itemBuilder: (context, int index) {
                        StockModel data = stock.igdStock[index];
                        int igdId = data.igdInfoId;

                        String imageUrl = baseUrlImage + 'igd/' + data.image;
                        return CardStock(
                          name: data.name,
                          imageUrl: imageUrl,
                          fn: () {
                            showDialog(
                              context: context,
                              builder: (context) => AlertDialog(
                                title: Text('การยืนยัน'),
                                content: Column(
                                  mainAxisSize: MainAxisSize.min,
                                  children: [
                                    Text('คุณต้องการลบวัตถุดิบนี้ใช่หรือไม่'),
                                  ],
                                ),
                                actions: [
                                  TextButton(
                                    onPressed: () {
                                      Navigator.pop(context);
                                      deleteStock(igdId);
                                      setState(() {
                                        readToken();
                                      });
                                      final text = 'ลบวัตถุดิบเรียบร้อย';
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
                          textButton: 'ลบ',
                          colorButton: Colors.red,
                          value: data.value.toString(),
                        );
                      }),
                ),
              ],
            );
          } else {
            return Column(
              children: [
                Padding(
                  padding: const EdgeInsets.all(8.0),
                  child: Row(
                    children: [
                      Text(
                        'รายการวัตถุดิบในคลัง',
                        style: TextStyle(fontSize: 20),
                      ),
                      SizedBox(
                        width: 10,
                      ),
                      Expanded(
                        child: ElevatedButton(
                          child: Text('เพิ่มวัตถุดิบในคลัง'),
                          style: ButtonStyle(
                            backgroundColor:
                                MaterialStateProperty.all<Color>(Colors.orange),
                          ),
                          onPressed: () {
                            Navigator.push(
                              context,
                              MaterialPageRoute(
                                builder: (context) {
                                  return ShowAddStockScreen();
                                },
                              ),
                            );
                          },
                        ),
                      ),
                    ],
                  ),
                ),
                Expanded(
                  child: ListView.builder(
                      itemCount: 1,
                      itemBuilder: (context, int index) {
                        return Column(
                          children: [
                            Text(
                              'ไม่มีข้อมูล',
                              style: TextStyle(fontSize: 20, color: Colors.red),
                            ),
                          ],
                        );
                      }),
                ),
              ],
            );
          }
        })),
      ),
    );
  }
}
