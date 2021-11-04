import 'package:flutter/material.dart';
import 'package:form_field_validator/form_field_validator.dart';

class CardAddStock extends StatelessWidget {
  final String name;
  final String imageUrl;
  final Function fn;
  final String textButton;
  final Color colorButton;
  final TextEditingController controller;

  const CardAddStock(
      {Key? key,
      required this.name,
      required this.imageUrl,
      required this.fn,
      required this.textButton,
      required this.colorButton,
      required this.controller})
      : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.all(1.0),
      child: Card(
        clipBehavior: Clip.antiAlias,
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(10),
        ),
        child: Padding(
          padding: const EdgeInsets.all(8.0),
          child: Column(
            children: [
              Row(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  buildCircleImage(
                    image: NetworkImage(imageUrl),
                  ),
                ],
              ),
              SizedBox(
                height: 5,
              ),
              Padding(
                padding:
                    const EdgeInsets.symmetric(horizontal: 20, vertical: 5),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      name,
                      style: TextStyle(fontSize: 20),
                    ),
                    SizedBox(
                      height: 10,
                    ),
                    Row(
                      children: [
                        Text('จำนวน'),
                        SizedBox(
                          width: 5,
                        ),
                        Expanded(
                          child: Container(
                            padding: EdgeInsets.all(8.0),
                            decoration: BoxDecoration(
                              color: Colors.grey[200],
                              borderRadius: BorderRadius.circular(10),
                            ),
                            child: TextFormField(
                              controller: controller,
                              validator: MultiValidator([
                                RequiredValidator(
                                    errorText: "กรุณาป้อนจำนวนด้วยครับ"),
                                RangeValidator(
                                    min: 0,
                                    max: 100000,
                                    errorText: "จำนวน 0 - 100000 กรัม")
                              ]),
                              decoration: InputDecoration(
                                hintText: "ป้อนจำนวน",
                                border: InputBorder.none,
                              ),
                              keyboardType: TextInputType.number,
                            ),
                          ),
                        ),
                        SizedBox(
                          width: 5,
                        ),
                        Text('กรัม'),
                      ],
                    ),
                    SizedBox(
                      height: 10,
                    ),
                    Column(
                      mainAxisAlignment: MainAxisAlignment.end,
                      crossAxisAlignment: CrossAxisAlignment.end,
                      children: [
                        Container(
                          width: double.infinity,
                          child: ElevatedButton(
                            child: Text(textButton),
                            style: ButtonStyle(
                              backgroundColor:
                                  MaterialStateProperty.all<Color>(colorButton),
                            ),
                            onPressed: () {
                              fn();
                            },
                          ),
                        ),
                      ],
                    ),
                  ],
                ),
              ),
            ],
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
