import 'package:flutter/material.dart';

class CardAddFoodAllergy extends StatelessWidget {
  final String name;
  final String imageUrl;
  final Function fn;
  final String textButton;
  final Color colorButton;

  const CardAddFoodAllergy({
    Key? key,
    required this.name,
    required this.imageUrl,
    required this.fn,
    required this.textButton,
    required this.colorButton,
  }) : super(key: key);

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
                    Text(name),
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
                    ElevatedButton(
                      child: Text(textButton),
                      style: ButtonStyle(
                        backgroundColor:
                            MaterialStateProperty.all<Color>(colorButton),
                      ),
                      onPressed: () {
                        fn();
                      },
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
