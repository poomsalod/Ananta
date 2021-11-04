import 'dart:convert';

List<CateIgdModel> cateIgdModelFromJson(String str) => List<CateIgdModel>.from(
    json.decode(str).map((x) => CateIgdModel.fromJson(x)));

String cateIgdModelToJson(List<CateIgdModel> data) =>
    json.encode(List<dynamic>.from(data.map((x) => x.toJson())));

class CateIgdModel {
  CateIgdModel({
    required this.cateIgdId,
    required this.name,
  });

  int cateIgdId;
  String name;

  factory CateIgdModel.fromJson(Map<String, dynamic> json) => CateIgdModel(
        cateIgdId: json["cate_igd_id"],
        name: json["name"],
      );

  Map<String, dynamic> toJson() => {
        "cate_igd_id": cateIgdId,
        "name": name,
      };
}
