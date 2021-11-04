import 'package:ananta/Model/igd_for_allergy.dart';
import 'package:ananta/Screens/FoodAllergy/add/addFoodAllergy.dart';
import 'package:ananta/Services/auth.dart';
import 'package:ananta/Services/food_allergy.dart';
import 'package:ananta/components/card_addFoodAllergy.dart';
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
      Provider.of<FoodAllergy>(context, listen: false)
          .fetchFoodAllergy(token: token == null ? '' : token, userId: userId);
    });
  }

  Future<Null> deleteFoodAllergy(int igdId) async {
    final token = await storage.read(key: 'token');
    setState(() {
      print(token);
      int userId = Provider.of<Auth>(context, listen: false).profile.user_id;
      Provider.of<FoodAllergy>(context, listen: false).deleteFoodAllergy(
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
        child: Center(child:
            Consumer<FoodAllergy>(builder: (context, food_allergy, child) {
          if (food_allergy.igdAllergy.length != 0) {
            return Column(
              children: [
                Padding(
                  padding: const EdgeInsets.all(8.0),
                  child: Row(
                    children: [
                      Text(
                        'รายการวัตถุดิบที่แพ้',
                        style: TextStyle(fontSize: 20),
                      ),
                      SizedBox(
                        width: 10,
                      ),
                      Expanded(
                        child: ElevatedButton(
                          child: Text('เพิ่มวัตถุดิบที่แพ้'),
                          style: ButtonStyle(
                            backgroundColor:
                                MaterialStateProperty.all<Color>(Colors.orange),
                          ),
                          onPressed: () {
                            Navigator.push(
                              context,
                              MaterialPageRoute(
                                builder: (context) {
                                  return AddFoodAllergyScreen();
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
                      itemCount: food_allergy.igdAllergy.length,
                      itemBuilder: (context, int index) {
                        IgdModal data = food_allergy.igdAllergy[index];
                        int igdId = data.igdInfoId;

                        String imageUrl = baseUrlImage + 'igd/' + data.image;
                        return CardAddFoodAllergy(
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
                                      deleteFoodAllergy(igdId);
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
                        'รายการวัตถุดิบที่แพ้',
                        style: TextStyle(fontSize: 20),
                      ),
                      SizedBox(
                        width: 10,
                      ),
                      Expanded(
                        child: ElevatedButton(
                          child: Text('เพิ่มวัตถุดิบที่แพ้'),
                          style: ButtonStyle(
                            backgroundColor:
                                MaterialStateProperty.all<Color>(Colors.orange),
                          ),
                          onPressed: () {
                            Navigator.push(
                              context,
                              MaterialPageRoute(
                                builder: (context) {
                                  return AddFoodAllergyScreen();
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
