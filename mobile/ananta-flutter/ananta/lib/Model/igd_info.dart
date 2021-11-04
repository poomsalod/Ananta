// To parse this JSON data, do
//
//     final igdInfoModel = igdInfoModelFromJson(jsonString);

import 'package:meta/meta.dart';
import 'dart:convert';

IgdInfoModel igdInfoModelFromJson(String str) =>
    IgdInfoModel.fromJson(json.decode(str));

String igdInfoModelToJson(IgdInfoModel data) => json.encode(data.toJson());

class IgdInfoModel {
  IgdInfoModel({
    required this.igdInfoId,
    required this.name,
    required this.image,
    required this.cateIgdId,
    required this.calorie,
    required this.fat,
    required this.protein,
    required this.carbohydrate,
    required this.fiber,
    required this.adminId,
    required this.addess,
    required this.addessImg,
    required this.createdAt,
    required this.updatedAt,
  });

  int igdInfoId;
  String name;
  String image;
  int cateIgdId;
  double calorie;
  double fat;
  double protein;
  double carbohydrate;
  double fiber;
  int adminId;
  String addess;
  String addessImg;
  DateTime createdAt;
  DateTime updatedAt;

  factory IgdInfoModel.fromJson(Map<String, dynamic> json) => IgdInfoModel(
        igdInfoId: json["igd_info_id"],
        name: json["name"],
        image: json["image"],
        cateIgdId: json["cate_igd_id"],
        calorie: json["calorie"].toDouble(),
        fat: json["fat"].toDouble(),
        protein: json["protein"].toDouble(),
        carbohydrate: json["carbohydrate"].toDouble(),
        fiber: json["fiber"].toDouble(),
        adminId: json["admin_id"],
        addess: json["addess"],
        addessImg: json["addess_img"],
        createdAt: DateTime.parse(json["created_at"]),
        updatedAt: DateTime.parse(json["updated_at"]),
      );

  Map<String, dynamic> toJson() => {
        "igd_info_id": igdInfoId,
        "name": name,
        "image": image,
        "cate_igd_id": cateIgdId,
        "calorie": calorie,
        "fat": fat,
        "protein": protein,
        "carbohydrate": carbohydrate,
        "fiber": fiber,
        "admin_id": adminId,
        "addess": addess,
        "addess_img": addessImg,
        "created_at": createdAt.toIso8601String(),
        "updated_at": updatedAt.toIso8601String(),
      };
}
