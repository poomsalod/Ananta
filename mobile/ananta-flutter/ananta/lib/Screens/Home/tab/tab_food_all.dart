import 'package:ananta/Model/cate_food.dart';
import 'package:ananta/Model/food_all.dart';
import 'package:ananta/Screens/Home/tab/details/details.dart';
import 'package:ananta/Services/auth.dart';
import 'package:ananta/Services/food.dart';
import 'package:ananta/components/card_common_food.dart';
import 'package:ananta/components/search.dart';
import 'package:ananta/constants.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter_secure_storage/flutter_secure_storage.dart';
import 'package:provider/provider.dart';

class FoodAllTab extends StatefulWidget {
  const FoodAllTab({Key? key}) : super(key: key);

  @override
  _FoodAllTabState createState() => _FoodAllTabState();
}

class _FoodAllTabState extends State<FoodAllTab> {
  final storage = new FlutterSecureStorage();
  ScrollController _scrollController = ScrollController();
  int _currentMax = 5;
  int dataMax = 0;

  //search
  List<FoodAllModel> dataSearch = [];
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
      Provider.of<Food>(context, listen: false)
          .fetchFood(token: token == null ? '' : token, userId: userId);
    });
  }

  _getMoreData() {
    if (_currentMax < dataMax) {
      if (dataMax - _currentMax < 5) {
        _currentMax = _currentMax + dataMax - _currentMax;
      } else {
        _currentMax = _currentMax + 5;
      }
    }
    setState(() {});
  }
  // void readToken() async {
  //   String token = '';
  //   token = (await storage.read(key: 'token'))!;
  //   print(token);
  //   Provider.of<Food>(context, listen: false).fetchFood(token: token);
  // }

  @override
  Widget build(BuildContext context) {
    return Center(child: Consumer<Food>(builder: (context, food, child) {
      if (food.orderFood.length != 0) {
        // dataCateFood
        List<String> nameCate = [];
        List<int> idCate = [];
        for (int i = 0; i < food.orderCateFood.length; i++) {
          CateFoodModel cateFood = food.orderCateFood[i];
          nameCate.add(cateFood.name);
          idCate.add(cateFood.cateFoodId);
        }
        nameCate.add('ทั้งหมด');
        idCate.add(0);

        return Column(
          children: [
            SearchWidget(
              text: query,
              onChangedFood: searchFood,
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
                    FoodAllModel data = food.orderFood[index];
                    dataMax = food.orderFood.length;
                    if (chackSearch == 1) {
                      data = dataSearch[index];
                      dataMax = dataSearch.length;
                    }

                    int foodId = data.foodId;
                    // String image = 'http://10.0.2.2:8000/storage/images/food/' +
                    //     data.image;
                    // String image2 =
                    //     'http://www.anan-ta.online/storage/images/food/' +
                    //         data.image;
                    // String image3 =
                    //     'http://10.0.2.2:8000/api/basics?id=975927117.jpg';
                    // String image4 =
                    //     'http://www.anan-ta.online/api/basics?id=975927117.jpg';
                    String imageUrl = baseUrlImage + 'food/' + data.image;
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
                      img: imageUrl,
                      // name: food.orderFood.length.toString(),
                      name: data.name.toString(),
                      calorie: data.calorie.toInt().toString(),
                      percentUserCook: data.percentUserCook.toString(),
                    );
                  }),
            ),
          ],
        );
      } else {
        return Center(child: CircularProgressIndicator());
      }
    }));
  }

  void searchFood(String query) {
    final allFood =
        Provider.of<Food>(context, listen: false).orderFood.where((element) {
      final nameLower = element.name.toLowerCase();
      final searchLower = query.toLowerCase();
      return nameLower.contains(searchLower);
    }).toList();

    setState(() {
      this.dataSearch = allFood;
      this.query = query;
      this.chackSearch = 1;
      this._currentMax = allFood.length;
    });
  }

  void searchCate(int query) {
    if (query == 0) {
      final allFood =
          Provider.of<Food>(context, listen: false).orderFood.where((element) {
        final nameLower = element.name.toLowerCase();
        final searchLower = "".toLowerCase();
        return nameLower.contains(searchLower);
      }).toList();
      setState(() {
        this.dataSearch = allFood;
        this.query = '';
        this.chackSearch = 1;
        this._currentMax = allFood.length;
      });
    } else {
      final allFood =
          Provider.of<Food>(context, listen: false).orderFood.where((element) {
        final cateNum = element.cateFoodId;
        final searchLower = query;
        return cateNum == searchLower;
      }).toList();
      setState(() {
        this.dataSearch = allFood;
        this.query = '';
        this.chackSearch = 1;
        this._currentMax = allFood.length;
      });
    }
  }
}
