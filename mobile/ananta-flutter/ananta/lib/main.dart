import 'package:ananta/Screens/Login/login.dart';
import 'package:ananta/Screens/Welcome/welcome.dart';
import 'package:ananta/Services/auth.dart';
import 'package:ananta/Services/food.dart';
import 'package:ananta/Services/food_allergy.dart';
import 'package:ananta/Services/food_details.dart';
import 'package:ananta/Services/hisyory.dart';
import 'package:ananta/Services/nutrition.dart';
import 'package:ananta/Services/rating.dart';
import 'package:ananta/Services/stock.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

void main() {
  runApp(MultiProvider(
    providers: [
      ChangeNotifierProvider(
        create: (context) => Auth(),
      ),
      ChangeNotifierProvider(
        create: (context) => Food(),
      ),
      ChangeNotifierProvider(
        create: (context) => FoodDetail(),
      ),
      ChangeNotifierProvider(
        create: (context) => History(),
      ),
      ChangeNotifierProvider(
        create: (context) => NutritionPro(),
      ),
      ChangeNotifierProvider(
        create: (context) => Rating(),
      ),
      ChangeNotifierProvider(
        create: (context) => FoodAllergy(),
      ),
      ChangeNotifierProvider(
        create: (context) => Stock(),
      ),
    ],
    child: MyApp(),
  ));
}

class MyApp extends StatelessWidget {
  // This widget is the root of your application.
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'Flutter Demo',
      theme: ThemeData(
        primaryColor: Colors.blue,
        scaffoldBackgroundColor: Colors.white,
      ),
      home: LoginScreen(),
    );
  }
}
