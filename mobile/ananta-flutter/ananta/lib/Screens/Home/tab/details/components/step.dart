import 'package:ananta/Model/step_of_food.dart';
import 'package:ananta/Services/food_details.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

class StepScreen extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    final List<StepOfFoodModel> stepOfFood =
        Provider.of<FoodDetail>(context, listen: false).stepOfFood;

    return SingleChildScrollView(
      child: Padding(
        padding: const EdgeInsets.only(bottom: 12.0),
        child: Column(
          children: [
            ListView.separated(
              shrinkWrap: true,
              physics: ScrollPhysics(),
              itemCount: stepOfFood.length,
              itemBuilder: (BuildContext context, int index) {
                StepOfFoodModel step = stepOfFood[index];
                String data = step.step;
                if (stepOfFood.length != 1) {
                  data = (index + 1).toString() + '. ' + data;
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
                        crossAxisAlignment: CrossAxisAlignment.center,
                        children: [
                          // buildCircleImage(order: step.order.toString()),
                          // // Text('ขั้นตอนที่ ' + step.order.toString()),
                          // SizedBox(
                          //   width: 5,
                          // ),
                          Expanded(
                            child: Column(
                              mainAxisAlignment: MainAxisAlignment.start,
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                Text(data),
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
  required String order,
}) =>
    CircleAvatar(
      backgroundColor: Colors.grey[300],
      radius: 28,
      child: CircleAvatar(
          backgroundColor: Colors.grey[50],
          foregroundColor: Colors.red,
          radius: 24,
          child: Text(
            order,
            style: TextStyle(fontWeight: FontWeight.bold, fontSize: 32),
          )),
    );
