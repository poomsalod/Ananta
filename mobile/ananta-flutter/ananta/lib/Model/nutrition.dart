import 'dart:convert';

List<Nutrition> nutritionFromJson(String str) =>
    List<Nutrition>.from(json.decode(str).map((x) => Nutrition.fromJson(x)));

String nutritionToJson(List<Nutrition> data) =>
    json.encode(List<dynamic>.from(data.map((x) => x.toJson())));

class Nutrition {
  Nutrition({
    required this.userNutritionId,
    required this.userId,
    required this.gender,
    required this.weight,
    required this.height,
    required this.activity,
    required this.bmr,
    required this.bmi,
    required this.tdee,
    required this.analyzeBmi,
    required this.createdAt,
    required this.updatedAt,
  });

  int userNutritionId;
  int userId;
  int gender;
  double weight;
  double height;
  double activity;
  double bmr;
  double bmi;
  double tdee;
  int analyzeBmi;
  DateTime createdAt;
  DateTime updatedAt;

  factory Nutrition.fromJson(Map<String, dynamic> json) => Nutrition(
        userNutritionId: json["user_nutrition_id"],
        userId: json["user_id"],
        gender: json["gender"],
        weight: json["weight"].toDouble(),
        height: json["height"].toDouble(),
        activity: json["activity"].toDouble(),
        bmr: json["bmr"].toDouble(),
        bmi: json["bmi"].toDouble(),
        tdee: json["tdee"].toDouble(),
        analyzeBmi: json["analyze_bmi"],
        createdAt: DateTime.parse(json["created_at"]),
        updatedAt: DateTime.parse(json["updated_at"]),
      );

  Map<String, dynamic> toJson() => {
        "user_nutrition_id": userNutritionId,
        "user_id": userId,
        "gender": gender,
        "weight": weight,
        "height": height,
        "activity": activity,
        "bmr": bmr,
        "bmi": bmi,
        "tdee": tdee,
        "analyze_bmi": analyzeBmi,
        "created_at": createdAt.toIso8601String(),
        "updated_at": updatedAt.toIso8601String(),
      };
}
