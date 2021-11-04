import 'dart:convert';

List<StockModel> stockModelFromJson(String str) =>
    List<StockModel>.from(json.decode(str).map((x) => StockModel.fromJson(x)));

String stockModelToJson(List<StockModel> data) =>
    json.encode(List<dynamic>.from(data.map((x) => x.toJson())));

class StockModel {
  StockModel({
    required this.igdInfoId,
    required this.name,
    required this.image,
    required this.cateIgdId,
    required this.value,
  });

  int igdInfoId;
  String name;
  String image;
  int cateIgdId;
  double value;

  factory StockModel.fromJson(Map<String, dynamic> json) => StockModel(
        igdInfoId: json["igd_info_id"],
        name: json["name"],
        image: json["image"],
        cateIgdId: json["cate_igd_id"],
        value: json["value"].toDouble(),
      );

  Map<String, dynamic> toJson() => {
        "igd_info_id": igdInfoId,
        "name": name,
        "image": image,
        "cate_igd_id": cateIgdId,
        "value": value,
      };
}
