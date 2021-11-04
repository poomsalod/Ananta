import 'package:ananta/Model/food.dart';
import 'package:ananta/Model/rating.dart';
import 'package:ananta/Screens/Home/tab/details/components/ingredients.dart';
import 'package:ananta/Screens/Home/tab/details/components/nutrition.dart';
import 'package:ananta/Screens/Home/tab/details/components/step.dart';
import 'package:ananta/Services/auth.dart';
import 'package:ananta/Services/food.dart';
import 'package:ananta/Services/food_details.dart';
import 'package:ananta/Services/rating.dart';
import 'package:ananta/constants.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter_rating_bar/flutter_rating_bar.dart';
import 'package:flutter_secure_storage/flutter_secure_storage.dart';
import 'package:provider/provider.dart';
import 'package:sliding_up_panel/sliding_up_panel.dart';
import 'package:tab_indicator_styler/tab_indicator_styler.dart';

class FoodDetailScreen extends StatefulWidget {
  int foodId;
  FoodDetailScreen({
    Key? key,
    required this.foodId,
  }) : super(key: key);

  @override
  _FoodDetailScreenState createState() =>
      _FoodDetailScreenState(foodId: foodId);
}

class _FoodDetailScreenState extends State<FoodDetailScreen> {
  int foodId;
  _FoodDetailScreenState({
    required this.foodId,
  });

  final storage = new FlutterSecureStorage();

  double rating = 0;
  double updateRating = 0;

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
      Provider.of<FoodDetail>(context, listen: false).fetchFoodDetail(
        token: token == null ? '' : token,
        foodId: foodId,
        userId: userId,
      );
    });
  }

  Future<Null> addRating() async {
    final token = await storage.read(key: 'token');
    setState(() {
      print(token);
      int userId = Provider.of<Auth>(context, listen: false).profile.user_id;
      Map creds = {
        'user_id': userId.toString(),
        'food_id': foodId.toString(),
        'score_rating': updateRating.toInt().toString(),
      };
      Provider.of<Rating>(context, listen: false)
          .addRating(token: token == null ? '' : token, creds: creds);
    });
  }

  void _confirm(BuildContext context) {
    int userId = Provider.of<Auth>(context, listen: false).profile.user_id;
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: Text('กรุณา ยืนยัน'),
        content: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            Text('คุณต้องการบันทึกประวัติการรับประทานใช่หรือไม่'),
          ],
        ),
        actions: [
          TextButton(
            onPressed: () {
              setState(() {
                Map creds = {
                  'food_id': foodId,
                  'user_id': userId,
                };
                Provider.of<Food>(context, listen: false)
                    .addHistory(creds: creds);

                final text = 'บันทึกประวัติการรับประทานเรียบร้อย';
                final snackBar = SnackBar(content: Text(text));

                ScaffoldMessenger.of(context).showSnackBar(snackBar);
                Navigator.of(context).pop();
              });
            },
            child: Text('บันทึก'),
          ),
          TextButton(
            onPressed: () {
              Navigator.pop(context);
            },
            child: Text(
              'ยกเลิก',
              style: TextStyle(color: Colors.red),
            ),
          )
        ],
      ),
    );
    // showCupertinoDialog(
    //     context: context,
    //     builder: (BuildContext ctx) {
    //       return CupertinoAlertDialog(
    //         title: Text('กรุณา ยืนยัน'),
    //         content: Text('คุณต้องการบันทึกประวัติการรับประทานใช่หรือไม่'),
    //         actions: [
    //           // The "Yes" button
    //           CupertinoDialogAction(
    //             onPressed: () {
    //               setState(() {
    //                 Map creds = {
    //                   'food_id': foodId,
    //                   'user_id': userId,
    //                 };
    //                 Provider.of<Food>(context, listen: false)
    //                     .addHistory(creds: creds);

    //                 final text = 'บันทึกประวัติการรับประทานเรียบร้อย';
    //                 final snackBar = SnackBar(content: Text(text));

    //                 ScaffoldMessenger.of(context).showSnackBar(snackBar);
    //                 Navigator.of(context).pop();
    //               });
    //             },
    //             child: Text('ใช่'),
    //             isDefaultAction: false,
    //             isDestructiveAction: false,
    //           ),
    //           // The "No" button
    //           CupertinoDialogAction(
    //             onPressed: () {
    //               Navigator.of(context).pop();
    //             },
    //             child: Text('ไม่'),
    //             isDefaultAction: true,
    //             isDestructiveAction: true,
    //           )
    //         ],
    //       );
    //     });
  }

  @override
  Widget build(BuildContext context) {
    Size size = MediaQuery.of(context).size;
    final _textTheme = Theme.of(context).textTheme;
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
      body: Consumer<FoodDetail>(
        builder: (context, food, child) {
          if (food.food.length != 0) {
            FoodModel data = food.food[0];
            // String image =
            //     'http://www.anan-ta.online/storage/images/food/' + data.image;
            String imageUrl = baseUrlImage + '/food/' + data.image;

            List<RatingModel> userRating =
                Provider.of<FoodDetail>(context, listen: false).rating;
            this.rating = userRating[0].rating - 0.1;
            return SafeArea(
              child: SlidingUpPanel(
                parallaxEnabled: true,
                borderRadius: BorderRadius.only(
                  topLeft: Radius.circular(24),
                  topRight: Radius.circular(24),
                ),
                padding: EdgeInsets.symmetric(
                  horizontal: 12,
                ),
                minHeight: (size.height / 2.5),
                maxHeight: size.height / 1.2,
                panel: Padding(
                  padding: const EdgeInsets.all(16.0),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Center(
                        child: Container(
                          height: 5,
                          width: 40,
                          decoration: BoxDecoration(
                            color: Colors.black.withOpacity(0.3),
                            borderRadius: BorderRadius.circular(12),
                          ),
                        ),
                      ),
                      SizedBox(
                        height: 30,
                      ),
                      //ชื่อ
                      Text(
                        data.name,
                        style: _textTheme.headline5,
                      ),
                      SizedBox(
                        height: 10,
                      ),
                      Row(
                        children: [
                          Text(
                            'พลังงาน ' +
                                data.calorie.toInt().toString() +
                                ' kcal',
                            style: _textTheme.caption,
                          ),
                          Expanded(
                              child: Column(
                            crossAxisAlignment: CrossAxisAlignment.end,
                            children: [
                              buildRating(),
                            ],
                          ))
                        ],
                      ),

                      SizedBox(
                        height: 10,
                      ),
                      Divider(
                        color: Colors.black.withOpacity(0.3),
                      ),
                      Center(
                        child: Text(
                          'สารอาหาร',
                          style: _textTheme.bodyText1,
                        ),
                      ),
                      SizedBox(
                        height: 10,
                      ),
                      Row(
                        children: [
                          NutritionBox(data: 'C'),
                          Container(
                            width: 2,
                            height: 30,
                            color: Colors.black,
                          ),
                          NutritionBox(data: 'P'),
                          Container(
                            width: 2,
                            height: 30,
                            color: Colors.black,
                          ),
                          NutritionBox(data: 'F'),
                          Container(
                            width: 2,
                            height: 30,
                            color: Colors.black,
                          ),
                          NutritionBox(data: 'Fi'),
                        ],
                      ),
                      Row(
                        children: [
                          NutritionBox(
                              data: (data.carbohydrate.toInt().toString()) +
                                  ' g'),
                          Container(
                            width: 2,
                            height: 30,
                            color: Colors.black,
                          ),
                          NutritionBox(
                              data: (data.protein.toInt().toString()) + ' g'),
                          Container(
                            width: 2,
                            height: 30,
                            color: Colors.black,
                          ),
                          NutritionBox(
                              data: (data.fat.toInt().toString()) + ' g'),
                          Container(
                            width: 2,
                            height: 30,
                            color: Colors.black,
                          ),
                          NutritionBox(
                              data: (data.fiber.toInt().toString()) + ' g'),
                        ],
                      ),
                      SizedBox(
                        height: 10,
                      ),
                      Divider(
                        color: Colors.black.withOpacity(0.3),
                      ),
                      Expanded(
                        child: DefaultTabController(
                          length: 2,
                          initialIndex: 0,
                          child: Column(
                            children: [
                              TabBar(
                                isScrollable: true,
                                indicatorColor: Colors.red,
                                tabs: [
                                  Tab(
                                    text: "Ingredients".toUpperCase(),
                                  ),
                                  Tab(
                                    text: "Step".toUpperCase(),
                                  ),
                                  // Tab(
                                  //   text: "Reviews".toUpperCase(),
                                  // ),
                                ],
                                labelColor: Colors.black,
                                indicator: DotIndicator(
                                  color: Colors.black,
                                  distanceFromCenter: 16,
                                  radius: 3,
                                  paintingStyle: PaintingStyle.fill,
                                ),
                                unselectedLabelColor:
                                    Colors.black.withOpacity(0.3),
                                labelStyle: TextStyle(
                                  fontSize: 12,
                                  fontWeight: FontWeight.w600,
                                ),
                                labelPadding: EdgeInsets.symmetric(
                                  horizontal: 32,
                                ),
                              ),
                              Divider(
                                color: Colors.black.withOpacity(0.3),
                              ),
                              Expanded(
                                child: TabBarView(
                                  children: [
                                    IngredientScreen(),
                                    StepScreen(),
                                    // Container(
                                    //   child: Text("Reviews Tab"),
                                    // ),
                                  ],
                                ),
                              )
                            ],
                          ),
                        ),
                      ),
                      Center(
                        child: Row(
                          children: [
                            ElevatedButton(
                              child: Text('ให้คะแนน'),
                              style: ButtonStyle(
                                backgroundColor:
                                    MaterialStateProperty.all<Color>(
                                        Colors.orange),
                              ),
                              onPressed: () => showRating(),
                            ),
                            SizedBox(
                              width: 5,
                            ),
                            Expanded(
                              child: ElevatedButton(
                                  child: Text('บันทึกประวัติการรับประทาน'),
                                  style: ButtonStyle(
                                    backgroundColor:
                                        MaterialStateProperty.all<Color>(
                                            Colors.orange),
                                  ),
                                  onPressed: () => _confirm(context)),
                            ),
                          ],
                        ),
                      ),
                    ],
                  ),
                ),
                body: SingleChildScrollView(
                  child: Stack(
                    children: [
                      Column(
                        mainAxisAlignment: MainAxisAlignment.start,
                        children: <Widget>[
                          Hero(
                            tag: imageUrl,
                            child: ClipRRect(
                              child: Image(
                                width: double.infinity,
                                height: (size.height / 2) + 50,
                                fit: BoxFit.cover,
                                image: NetworkImage(imageUrl),
                              ),
                            ),
                          ),
                        ],
                      ),
                      // Positioned(
                      //   top: 40,
                      //   right: 20,
                      //   child: Icon(
                      //     FlutterIcons.bookmark_outline_mco,
                      //     color: Colors.white,
                      //     size: 38,
                      //   ),
                      // ),
                      // Positioned(
                      //   top: 40,
                      //   left: 20,
                      //   child: InkWell(
                      //     onTap: () => Navigator.pop(context),
                      //     child: Icon(
                      //       CupertinoIcons.back,
                      //       color: Colors.white,
                      //       size: 38,
                      //     ),
                      //   ),
                      // ),
                    ],
                  ),
                ),
              ),
            );
          } else {
            return Center(child: CircularProgressIndicator());
          }
        },
      ),
      // This trailing comma makes auto-formatting nicer for build methods.
    );
  }

  Widget buildRating() => RatingBar.builder(
        initialRating: this.rating,
        maxRating: 1,
        itemBuilder: (context, _) => Icon(
          Icons.star,
          color: Colors.amber,
        ),
        itemSize: 30,
        updateOnDrag: true,
        onRatingUpdate: (updateRating) => setState(() {
          this.updateRating = updateRating;
        }),
      );

  void showRating() => showDialog(
        context: context,
        builder: (context) => AlertDialog(
          title: Text('กรุณาให้คะแนนเมนูอาหาร'),
          content: Column(
            mainAxisSize: MainAxisSize.min,
            children: [
              buildRating(),
            ],
          ),
          actions: [
            TextButton(
              onPressed: () {
                Navigator.pop(context);
                addRating();
                final text = 'บันทึกคะแนนเรียบร้อย';
                final snackBar = SnackBar(content: Text(text));

                ScaffoldMessenger.of(context).showSnackBar(snackBar);
              },
              child: Text('บันทึก'),
            ),
            TextButton(
              onPressed: () {
                Navigator.pop(context);
              },
              child: Text(
                'ยกเลิก',
                style: TextStyle(color: Colors.red),
              ),
            )
          ],
        ),
      );
}
