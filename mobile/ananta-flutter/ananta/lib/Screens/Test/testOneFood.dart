import 'package:ananta/Model/food.dart';
import 'package:ananta/Screens/Home/tab/details/details.dart';
import 'package:ananta/Services/api.dart';
import 'package:ananta/components/card_common_food.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter_secure_storage/flutter_secure_storage.dart';

class TestOneFoodScreen extends StatefulWidget {
  const TestOneFoodScreen({Key? key}) : super(key: key);

  @override
  _TestOneFoodScreenState createState() => _TestOneFoodScreenState();
}

class _TestOneFoodScreenState extends State<TestOneFoodScreen> {
  List<FoodModel> lodeFood = [];
  List<FoodModel> orderFood = [];
  final storage = new FlutterSecureStorage();
  ScrollController _scrollController = ScrollController();
  int _currentMax = 10;

  Future init() async {
    final token = await storage.read(key: 'token');
    final lodeFood = await FoodAllApi.getFood(token!);

    setState(() {
      this.lodeFood = lodeFood;
      orderFood = List.generate(1, (i) => lodeFood[i]);
    });
  }

  @override
  void initState() {
    super.initState();

    init();
    _scrollController.addListener(() {
      if (_scrollController.position.pixels ==
          _scrollController.position.maxScrollExtent) {
        _getMoreData();
      }
    });
  }

  _getMoreData() {
    for (int i = _currentMax; i < _currentMax + 10; i++) {
      orderFood.add(lodeFood[i]);
    }

    _currentMax = _currentMax + 10;

    setState(() {});
  }

  // Future<List<FoodModel>> _getFood() async {
  //   final token = await storage.read(key: 'token');
  //   final orderFood = await FoodAllApi.getFood(token!);

  //   return orderFood;
  // }
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(),
      body: ListView.builder(
        controller: _scrollController,
        itemBuilder: (context, int i) {
          if (i == orderFood.length) {
            return CupertinoActivityIndicator();
          }
          FoodModel data = orderFood[i];
          int foodId = data.foodId;
          String image =
              'http://10.0.2.2:8000/storage/images/food/' + data.image;
          String image2 =
              'http://www.anan-ta.online/storage/images/food/' + data.image;
          return CardCommonFood(
            ontab: () {
              Navigator.push(
                context,
                MaterialPageRoute(
                  builder: (context) {
                    return FoodDetailScreen(foodId: foodId);
                  },
                ),
              );
            },
            img: image2,
            // name: food.orderFood.length.toString(),
            name: data.name.toString(),
            calorie: data.calorie.toString(),
            percentUserCook: 'xx',
          );
        },
        itemCount: orderFood.length + 1,
      ),

      // FutureBuilder(
      //   future: _getFood(),
      //   builder: (BuildContext context, AsyncSnapshot<dynamic> snapshot) {
      //     if (snapshot.connectionState == ConnectionState.done) {
      //       return ListView.builder(
      //         itemCount: snapshot.data.length,
      //         itemBuilder: (context, int index) {
      //           FoodModel data = snapshot.data[index];
      //           String image =
      //               'http://10.0.2.2:8000/storage/images/food/' + data.image;
      //           String image2 =
      //               'http://www.anan-ta.online/storage/images/food/' +
      //                   data.image;
      //           return CardCommonFood(
      //             img: image2,
      //             // name: food.orderFood.length.toString(),
      //             name: data.name.toString(),
      //             calorie: data.calorie.toString(),
      //           );
      //         },
      //       );
      //     }

      //     return CircularProgressIndicator();
      //   },
      // )
    );
  }
}
