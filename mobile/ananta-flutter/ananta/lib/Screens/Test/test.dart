import 'package:ananta/Model/igd_info.dart';
import 'package:ananta/Model/igd_of_food.dart';
import 'package:ananta/Services/food_details.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

class TestScreen extends StatefulWidget {
  const TestScreen({Key? key}) : super(key: key);

  @override
  _TestScreenState createState() => _TestScreenState();
}

class _TestScreenState extends State<TestScreen> {
  final _img3 = 'http://10.0.2.2:8000/api/image?id=999152223.jpg';
  final _img = 'http://10.0.2.2:8000/storage/images/food/999152223.jpg';
  final _img2 = 'http://10.0.2.2:8000/storage/images/food/2144679189.jpg';
  final _imgli =
      'https://siamrath.co.th/files/styles/1140/public/img/20201104/df4261224495945b0ee254f902601dbed5c5026b6eaef5150c8f4f0117275bba.png?itok=eAkb1_JA';
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Center(
        child: Column(
          children: [
            Image.network(
              'http://10.0.2.2:8000/api/image?id=999152223.jpg',
              height: 100,
              width: 100,
            ),
            Image.network(
              'http://10.0.2.2:8000/api/image?id=1079563834.jpg',
              height: 100,
              width: 100,
            ),
            Image.network(
              'http://10.0.2.2:8000/api/image?id=975927117.jpg',
              height: 100,
              width: 100,
            ),
            Image.network(
              'http://10.0.2.2:8000/api/image?id=824406886.jpg',
              height: 100,
              width: 100,
            ),
            Image.network(
              'http://10.0.2.2:8000/api/image?id=1843128721.jpg',
              height: 100,
              width: 100,
            ),
            Image.network(
              'http://10.0.2.2:8000/api/image?id=1869496078.jpg',
              height: 100,
              width: 100,
            ),
            // Image.network(
            //   'http://10.0.2.2:8000/api/image?id=999152223.jpg',
            //   height: 100,
            //   width: 100,
            // ),
            // Image.network(
            //   'http://10.0.2.2:8000/api/image?id=1079563834.jpg',
            //   height: 100,
            //   width: 100,
            // ),
            // Image.network(
            //   'http://10.0.2.2:8000/api/image?id=975927117.jpg',
            //   height: 100,
            //   width: 100,
            // ),
            // Image.network(
            //   'http://10.0.2.2:8000/api/image?id=824406886.jpg',
            //   height: 100,
            //   width: 100,
            // ),
            // Image.network(
            //   'http://10.0.2.2:8000/api/image?id=1843128721.jpg',
            //   height: 100,
            //   width: 100,
            // ),
            // Image.network(
            //   'http://10.0.2.2:8000/api/image?id=1869496078.jpg',
            //   height: 100,
            //   width: 100,
            // ),
            // poo
            // Image.network(
            //   _img,
            //   height: 100,
            //   width: 100,
            //   loadingBuilder: (context, child, progress) {
            //     return progress == null ? child : LinearProgressIndicator();
            //   },
            // ),
            // Image.network(
            //   _img2,
            //   height: 100,
            //   width: 100,
            //   loadingBuilder: (context, child, progress) {
            //     return progress == null ? child : LinearProgressIndicator();
            //   },
            // ),
          ],
        ),
      ),
    );
  }
}

class TestIngredientScreen extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    final List<IgdInfoModel> igdInfo =
        Provider.of<FoodDetail>(context, listen: false).getigdInfo();
    final List<IgdOfFoodModel> igdOfFood =
        Provider.of<FoodDetail>(context, listen: false).getigdOfFood();
    return Scaffold(
      appBar: AppBar(),
      body: Padding(
        padding: const EdgeInsets.all(8.0),
        child: Card(
          clipBehavior: Clip.antiAlias,
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(10),
          ),
          child: Padding(
            padding: const EdgeInsets.all(8.0),
            child: Row(
              children: [
                buildCircleImage(
                  image: NetworkImage(
                      'https://upload.wikimedia.org/wikipedia/commons/8/85/Blackpink_Lisa_Vogue_2021.png'),
                ),
                SizedBox(
                  width: 5,
                ),
                Expanded(
                  child: Text('igd.name'),
                ),
                Expanded(
                  child: Row(
                    mainAxisAlignment: MainAxisAlignment.end,
                    children: [
                      Text('value'),
                    ],
                  ),
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }
}

Widget buildCircleImage({
  required ImageProvider image,
}) =>
    CircleAvatar(
      backgroundColor: Colors.cyan[100],
      backgroundImage: image,
      foregroundColor: Colors.white,
      radius: 24,
      onBackgroundImageError: image != null
          ? (e, stackTrace) {
              print('e: ${e}');
            }
          : null,
      child: image == null
          ? Text(
              'Loding..',
              style: TextStyle(fontWeight: FontWeight.bold, fontSize: 32),
            )
          : Container(height: 0, width: 0),
    );
