import 'package:flutter/material.dart';

class SearchWidget extends StatefulWidget {
  final String text;
  final ValueChanged<String> onChangedFood;
  final ValueChanged<int> onChangedCate;
  final String hintText;
  final List<String> nameCate;
  final List<int> idCate;

  const SearchWidget({
    Key? key,
    required this.text,
    required this.onChangedFood,
    required this.onChangedCate,
    required this.hintText,
    required this.nameCate,
    required this.idCate,
  }) : super(key: key);

  @override
  _SearchWidgetState createState() => _SearchWidgetState();
}

class _SearchWidgetState extends State<SearchWidget> {
  final controller = TextEditingController();
  String? value;

  @override
  Widget build(BuildContext context) {
    final styleActive = TextStyle(color: Colors.black);
    final styleHint = TextStyle(color: Colors.black54);
    final style = widget.text.isEmpty ? styleHint : styleActive;

    return Row(
      children: [
        Flexible(
          child: Container(
            height: 42,
            margin: const EdgeInsets.fromLTRB(16, 16, 16, 16),
            decoration: BoxDecoration(
              borderRadius: BorderRadius.circular(12),
              color: Colors.white,
              border: Border.all(color: Colors.black26),
            ),
            padding: const EdgeInsets.symmetric(horizontal: 8),
            child: TextField(
              controller: controller,
              decoration: InputDecoration(
                icon: Icon(Icons.search, color: style.color),
                suffixIcon: widget.text.isNotEmpty
                    ? GestureDetector(
                        child: Icon(Icons.close, color: style.color),
                        onTap: () {
                          controller.clear();
                          widget.onChangedFood('');
                          FocusScope.of(context).requestFocus(FocusNode());
                        },
                      )
                    : null,
                hintText: widget.hintText,
                hintStyle: style,
                border: InputBorder.none,
              ),
              style: style,
              onChanged: widget.onChangedFood,
            ),
          ),
        ),
        Container(
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
              items: widget.nameCate.map(buildMenuItem).toList(),
              onChanged: (value) {
                setState(() => this.value = value);
                int serachCate = 0;
                for (int i = 0; i < widget.nameCate.length; i++) {
                  if (value == widget.nameCate[i]) {
                    serachCate = widget.idCate[i];
                  }
                }

                widget.onChangedCate(serachCate);
              },
            ),
          ),
        ),
      ],
    );
  }

  DropdownMenuItem<String> buildMenuItem(String item) => DropdownMenuItem(
        value: item,
        child: Text(item),
      );
}
