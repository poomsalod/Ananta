import 'package:ananta/Model/cate_food.dart';
import 'package:ananta/Model/food.dart';
import 'package:ananta/Model/food_rec.dart';
import 'package:ananta/Screens/Home/tab/details/details.dart';
import 'package:ananta/Services/auth.dart';
import 'package:ananta/Services/food.dart';
// import 'package:ananta/components/card_common_food.dart';
import 'package:ananta/components/card_rec_food.dart';
import 'package:ananta/constants.dart';
import 'package:flutter/material.dart';
import 'package:flutter_secure_storage/flutter_secure_storage.dart';
import 'package:provider/provider.dart';

class FoodRecommendedTab extends StatefulWidget {
  const FoodRecommendedTab({Key? key}) : super(key: key);

  @override
  _FoodRecommendedTabState createState() => _FoodRecommendedTabState();
}

class _FoodRecommendedTabState extends State<FoodRecommendedTab> {
  final storage = new FlutterSecureStorage();
  String? value;
  // final nameCate = ['1', '2'];

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
      Provider.of<Food>(context, listen: false)
          .fetchRecFood(token: token == null ? '' : token, userId: userId);
    });
  }

  Future<Null> searchRecFood(int cateId) async {
    final token = await storage.read(key: 'token');
    setState(() {
      print(token);
      int userId = Provider.of<Auth>(context, listen: false).profile.user_id;
      Provider.of<Food>(context, listen: false).fetchSearchRecFood(
          token: token == null ? '' : token, userId: userId, cateId: cateId);
    });
  }

  // Future<Null> readUserId() async {
  //   final token = await storage.read(key: 'token');
  //   setState(() {
  //     print(token);
  //     Provider.of<Food>(context, listen: false)
  //         .fetchRecFood(token: token == null ? '' : token);
  //   });
  // }

  @override
  Widget build(BuildContext context) {
    int userId = Provider.of<Auth>(context, listen: false).profile.user_id;

    Size size = MediaQuery.of(context).size;
    return Center(child: Consumer<Food>(builder: (context, food, child) {
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
      if (food.orderRecFood.length != 0) {
        return Column(
          children: [
            RecDropCate(nameCate, idCate),
            Expanded(
              child: ListView.builder(
                  itemCount: food.orderRecFood.length,
                  itemBuilder: (context, int index) {
                    FoodRacommended data = food.orderRecFood[index];
                    int foodId = data.foodId;
                    // String image =
                    //     'http://10.0.2.2:8000/storage/images/food/' + data.image;
                    // String image2 =
                    //     'http://www.anan-ta.online/storage/images/food/' + data.image;
                    // final _img =
                    //     'http://10.0.2.2:8000/storage/images/food/999152223.jpg';
                    // final _img3 = 'http://10.0.2.2:8000/api/image?id=' + data.image;
                    String imageUrl = baseUrlImage + 'food/' + data.image;
                    return CardRecFood(
                      img: imageUrl,
                      // name: 'api/image?id=' + data.image,
                      name: data.name.toString(),
                      // calorie: foodId.toString() + userId.toString(),
                      calorie: data.calorie.toInt().toString(),
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
                      addHistoty: () {
                        Map creds = {
                          'food_id': foodId,
                          'user_id': userId,
                        };
                        Provider.of<Food>(context, listen: false)
                            .addHistory(creds: creds);
                      },
                      score:
                          (double.parse(data.scoreNutrition.toStringAsFixed(2)))
                              .toString(),
                      percentUserCook: data.percentUserCook.toString(),
                    );
                  }),
            ),
          ],
        );
      } else {
        return Column(
          children: [
            RecDropCate(nameCate, idCate),
            Center(child: CircularProgressIndicator()),
          ],
        );
      }
    }));
  }

  DropdownMenuItem<String> buildMenuItem(String item) => DropdownMenuItem(
        value: item,
        child: Text(item),
      );
  Widget RecDropCate(List<String> nameCate, List<int> idCate) {
    return Container(
      height: 42,
      margin: const EdgeInsets.fromLTRB(16, 16, 16, 16),
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(12),
        color: Colors.white,
        border: Border.all(color: Colors.black26),
      ),
      padding: const EdgeInsets.symmetric(horizontal: 8),
      child: DropdownButtonHideUnderline(
        child: DropdownButton<String>(
          iconSize: 24,
          icon: Icon(
            Icons.arrow_drop_down,
            color: Colors.black26,
          ),
          value: value,
          isExpanded: true,
          items: nameCate.map(buildMenuItem).toList(),
          onChanged: (value) {
            setState(() => this.value = value);
            int serachCate = 0;
            for (int i = 0; i < nameCate.length; i++) {
              if (value == nameCate[i]) {
                serachCate = idCate[i];
              }
            }
            searchRecFood(serachCate);
          },
        ),
      ),
    );
  }
}
