import 'dart:io';

import 'package:ananta/Model/profile.dart';
import 'package:ananta/Screens/FoodAllergy/food_allergy.dart';
import 'package:ananta/Screens/Home/tab/tab_food_rec.dart';
import 'package:ananta/Screens/Home/tab/tab_food_all.dart';
import 'package:ananta/Screens/Home/tab/tab_history.dart';
import 'package:ananta/Screens/Home/tab/tab_profile.dart';
import 'package:ananta/Screens/Login/login.dart';
import 'package:ananta/Screens/Stock/stock.dart';
import 'package:ananta/Services/auth.dart';
import 'package:ananta/Services/utils.dart';
import 'package:ananta/components/rounded_button.dart';
import 'package:ananta/constants.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:url_launcher/link.dart';
import 'package:url_launcher/url_launcher.dart';

class Body extends StatefulWidget {
  const Body({Key? key}) : super(key: key);

  @override
  _BodyState createState() => _BodyState();
}

class _BodyState extends State<Body> {
  String name = 'loding..';
  String imageUrl = baseUrlImage + 'avatar.jpg';

  @override
  void initState() {
    // TODO: implement initState
    super.initState();
    readProfile();
  }

  Future<Null> readProfile() async {
    final userProfile = await Provider.of<Auth>(context, listen: false).profile;
    setState(() {
      name = userProfile.l_name + '  ' + userProfile.l_name;
      imageUrl = baseUrlImage + 'user/' + userProfile.image;
    });
  }

  @override
  Widget build(BuildContext context) {
    // Profile user_profile = Provider.of<Auth>(context, listen: false).profile;
    // String image =
    //     'http://www.anan-ta.online/storage/images/user/' + user_profile.image;
    // String imageUrl = baseUrlImage + '/user/' + user_profile.image;
    Size size = MediaQuery.of(context).size;
    return DefaultTabController(
      length: 4,
      child: Scaffold(
        drawer: Drawer(
          child: Container(
            decoration: BoxDecoration(
              gradient: LinearGradient(
                colors: [Colors.orange, Colors.brown],
                begin: Alignment.bottomRight,
                end: Alignment.topLeft,
              ),
            ),
            child: SafeArea(
              child: Container(
                decoration: BoxDecoration(
                  gradient: LinearGradient(
                    colors: [Color(0xFFFFD691), Color(0xFFFFF6E8)],
                    begin: Alignment.bottomCenter,
                    end: Alignment.topCenter,
                  ),
                ),
                child: Padding(
                  padding: const EdgeInsets.all(0.0),
                  child: Column(
                    mainAxisAlignment: MainAxisAlignment.start,
                    children: <Widget>[
                      Card(
                        color: Color(0xFFFFF6E8),
                        clipBehavior: Clip.antiAlias,
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(10),
                        ),
                        child: Padding(
                          padding: const EdgeInsets.all(8.0),
                          child: Column(
                            mainAxisAlignment: MainAxisAlignment.center,
                            crossAxisAlignment: CrossAxisAlignment.center,
                            children: [
                              // CircleAvatar(
                              //   radius: 64,
                              //   backgroundColor: Colors.white,
                              //   child: CircleAvatar(
                              //     radius: 60,
                              //     backgroundImage: NetworkImage(imageUrl),
                              //     // child: Text('I'),
                              //     // backgroundImage:
                              //     //     AssetImage('assets/images/poom.jpg'),
                              //   ),
                              // ),
                              SizedBox(
                                height: 10,
                              ),
                              Row(
                                mainAxisAlignment: MainAxisAlignment.center,
                                children: [
                                  // Text(
                                  //   user_profile.f_name,
                                  //   style: TextStyle(
                                  //     fontSize: 20,
                                  //     fontWeight: FontWeight.bold,
                                  //     color: Colors.black,
                                  //   ),
                                  // ),
                                  // SizedBox(
                                  //   width: 5,
                                  // ),
                                  Text(
                                    name,
                                    // user_profile.l_name,
                                    style: TextStyle(
                                      fontSize: 20,
                                      fontWeight: FontWeight.bold,
                                      color: Colors.black,
                                    ),
                                  ),
                                ],
                              ),
                              SizedBox(
                                height: 20,
                              ),
                              // ElevatedButton(
                              //   onPressed: () =>
                              //       Utils.openLink(url: 'http://flutter.dev'),
                              //   child: Text('ไปที่เว็บไซต์'),
                              // ),
                              Column(
                                children: [
                                  Container(
                                    width: double.infinity,
                                    child: ElevatedButton(
                                      child: Text('ข้อมูลการแพ้อาหาร'),
                                      style: ButtonStyle(
                                        backgroundColor:
                                            MaterialStateProperty.all<Color>(
                                                Colors.orange),
                                      ),
                                      onPressed: () {
                                        Navigator.push(
                                          context,
                                          MaterialPageRoute(
                                            builder: (context) {
                                              return FoodAllergyScreen();
                                            },
                                          ),
                                        );
                                      },
                                    ),
                                  ),
                                  SizedBox(
                                    height: 5,
                                  ),
                                  Container(
                                    width: double.infinity,
                                    child: ElevatedButton(
                                      child: Text('คลังวัตถุดิบ'),
                                      style: ButtonStyle(
                                        backgroundColor:
                                            MaterialStateProperty.all<Color>(
                                                Colors.orange),
                                      ),
                                      onPressed: () {
                                        Navigator.push(
                                          context,
                                          MaterialPageRoute(
                                            builder: (context) {
                                              return StockScreen();
                                            },
                                          ),
                                        );
                                      },
                                    ),
                                  ),
                                  SizedBox(
                                    height: 5,
                                  ),
                                  Container(
                                    width: double.infinity,
                                    child: ElevatedButton(
                                      child: Text('LOGOUT'),
                                      style: ButtonStyle(
                                        backgroundColor:
                                            MaterialStateProperty.all<Color>(
                                                Colors.grey),
                                      ),
                                      onPressed: () {
                                        Provider.of<Auth>(context,
                                                listen: false)
                                            .logout();
                                        Navigator.of(context)
                                            .pushAndRemoveUntil(
                                                MaterialPageRoute(
                                                    builder: (context) =>
                                                        LoginScreen()),
                                                (Route<dynamic> route) =>
                                                    false);
                                      },
                                    ),
                                  ),
                                ],
                              ),
                            ],
                          ),
                        ),
                      ),
                    ],
                  ),
                ),
              ),
            ),
          ),
        ),
        appBar: AppBar(
          title: Image.asset(
            'assets/images/logo_ananta.png',
            width: 80,
          ),
          // Row(
          //   children: [
          //     Image.asset(
          //       'assets/images/logo_ananta.png',
          //       width: 50,
          //     ),
          //     SizedBox(
          //       width: 5,
          //     ),
          //     Text('Ananta'),
          //   ],
          // ),

          // centerTitle: true,
          // leading: IconButton(
          //   icon: Icon(Icons.menu),
          //   onPressed: () {},
          // ),
          // actions: [
          //   // IconButton(
          //   //   icon: Icon(Icons.notifications_none),
          //   //   onPressed: () {},
          //   // ),
          //   // IconButton(
          //   //   icon: Icon(Icons.search),
          //   //   onPressed: () {},
          //   // )

          //   Padding(
          //     padding: const EdgeInsets.all(10.0),
          //     child: CircleAvatar(
          //       radius: 18,
          //       backgroundColor: Colors.white,
          //       child: CircleAvatar(
          //           radius: 16,
          //           backgroundImage: NetworkImage(imageUrl),
          //           // backgroundColor: Colors.white,
          //           child: IconButton(
          //             icon: Icon(
          //               Icons.menu,
          //               color: Colors.amber.withOpacity(0),
          //             ),
          //             onPressed: () {
          //               showDialog(
          //                 context: context,
          //                 builder: (context) => AlertDialog(
          //                   title: Text('เมนู'),
          //                   content: Column(
          //                     mainAxisSize: MainAxisSize.min,
          //                     children: [
          //                       Container(
          //                         width: double.infinity,
          //                         child: ElevatedButton(
          //                           child: Text('ข้อมูลการแพ้อาหาร'),
          //                           style: ButtonStyle(
          //                             backgroundColor:
          //                                 MaterialStateProperty.all<Color>(
          //                                     Colors.orange),
          //                           ),
          //                           onPressed: () {
          //                             Navigator.push(
          //                               context,
          //                               MaterialPageRoute(
          //                                 builder: (context) {
          //                                   return FoodAllergyScreen();
          //                                 },
          //                               ),
          //                             );
          //                           },
          //                         ),
          //                       ),
          //                       // SizedBox(
          //                       //   height: 1,
          //                       // ),
          //                       Container(
          //                         width: double.infinity,
          //                         child: ElevatedButton(
          //                           child: Text('คลังวัตถุดิบ'),
          //                           style: ButtonStyle(
          //                             backgroundColor:
          //                                 MaterialStateProperty.all<Color>(
          //                                     Colors.orange),
          //                           ),
          //                           onPressed: () {
          //                             Navigator.push(
          //                               context,
          //                               MaterialPageRoute(
          //                                 builder: (context) {
          //                                   return StockScreen();
          //                                 },
          //                               ),
          //                             );
          //                           },
          //                         ),
          //                       ),
          //                       // SizedBox(
          //                       //   height: 1,
          //                       // ),
          //                       Container(
          //                         width: double.infinity,
          //                         child: ElevatedButton(
          //                           child: Text('LOGOUT'),
          //                           style: ButtonStyle(
          //                             backgroundColor:
          //                                 MaterialStateProperty.all<Color>(
          //                                     Colors.grey),
          //                           ),
          //                           onPressed: () {
          //                             Provider.of<Auth>(context, listen: false)
          //                                 .logout();
          //                             Navigator.of(context).pushAndRemoveUntil(
          //                                 MaterialPageRoute(
          //                                     builder: (context) =>
          //                                         LoginScreen()),
          //                                 (Route<dynamic> route) => false);
          //                           },
          //                         ),
          //                       ),
          //                     ],
          //                   ),
          //                   actions: [],
          //                 ),
          //               );
          //             },
          //           )),
          //     ),
          //   ),
          // ],
          backgroundColor: Colors.purple,
          flexibleSpace: Container(
            decoration: BoxDecoration(
              gradient: LinearGradient(
                colors: [Colors.orange, Colors.brown],
                begin: Alignment.bottomRight,
                end: Alignment.topLeft,
              ),
            ),
          ),
          bottom: TabBar(
            //isScrollable: true,
            indicatorColor: Colors.white,
            indicatorWeight: 5,
            tabs: [
              Tab(icon: Icon(Icons.fastfood_sharp), text: 'เมนูแนะนำ'),
              Tab(icon: Icon(Icons.food_bank_sharp), text: 'เมนูทั้งหมด'),
              Tab(icon: Icon(Icons.history), text: 'ประวัติ'),
              Tab(icon: Icon(Icons.face), text: 'โปรไฟล์'),
            ],
          ),
          elevation: 20,
          titleSpacing: 20,
        ),
        body: TabBarView(
          children: [
            FoodRecommendedTab(),
            FoodAllTab(),
            HistoryTab(),
            ProfileTab(),
          ],
        ),
      ),
    );
  }

  Widget buildPage(String text) => Center(
        child: Text(
          text,
          style: TextStyle(fontSize: 28),
        ),
      );
}
