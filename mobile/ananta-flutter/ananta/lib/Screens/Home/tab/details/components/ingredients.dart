import 'package:ananta/Model/igd_info.dart';
import 'package:ananta/Model/igd_of_food.dart';
import 'package:ananta/Services/food_details.dart';
import 'package:ananta/constants.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

class IngredientScreen extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    final List<IgdInfoModel> igdInfo =
        Provider.of<FoodDetail>(context, listen: false).getigdInfo();
    final List<IgdOfFoodModel> igdOfFood =
        Provider.of<FoodDetail>(context, listen: false).getigdOfFood();
    return SingleChildScrollView(
      child: Padding(
        padding: const EdgeInsets.only(bottom: 12.0),
        child: Column(
          children: [
            ListView.separated(
              shrinkWrap: true,
              physics: ScrollPhysics(),
              itemCount: igdOfFood.length,
              itemBuilder: (BuildContext context, int index) {
                IgdOfFoodModel iof = igdOfFood[index];
                IgdInfoModel igd = igdInfo[index];
                // String image =
                //     'http://www.anan-ta.online/storage/images/igd/' + igd.image;
                String imageUrl = baseUrlImage + '/igd/' + igd.image;
                String value = '';
                if (iof.value == 0) {
                  value = iof.description;
                } else {
                  value = iof.value.toString() + ' ' + iof.unit;
                }
                return Padding(
                  padding: const EdgeInsets.all(1.0),
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
                            image: NetworkImage(imageUrl),
                          ),
                          SizedBox(
                            width: 5,
                          ),
                          Expanded(
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                Text(igd.name),
                              ],
                            ),
                          ),
                          SizedBox(
                            width: 5,
                          ),
                          Expanded(
                            child: Column(
                              mainAxisAlignment: MainAxisAlignment.end,
                              crossAxisAlignment: CrossAxisAlignment.end,
                              children: [
                                Text(value),
                              ],
                            ),
                          ),
                        ],
                      ),
                    ),
                  ),
                );
              },
              separatorBuilder: (BuildContext context, int index) {
                return SizedBox(
                  height: 1,
                );
              },
            ),
          ],
        ),
      ),
    );
  }
}

Widget buildCircleImage({
  required ImageProvider image,
}) =>
    CircleAvatar(
      backgroundColor: Colors.grey[300],
      radius: 28,
      child: CircleAvatar(
        backgroundColor: Colors.grey[50],
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
                'I',
                style: TextStyle(fontWeight: FontWeight.bold, fontSize: 32),
              )
            : Container(height: 0, width: 0),
      ),
    );
