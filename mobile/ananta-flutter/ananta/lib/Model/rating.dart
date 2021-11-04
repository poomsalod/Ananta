import 'dart:convert';

List<RatingModel> ratingModelFromJson(String str) => List<RatingModel>.from(
    json.decode(str).map((x) => RatingModel.fromJson(x)));

String ratingModelToJson(List<RatingModel> data) =>
    json.encode(List<dynamic>.from(data.map((x) => x.toJson())));

class RatingModel {
  RatingModel({
    required this.rating,
  });

  double rating;

  factory RatingModel.fromJson(Map<String, dynamic> json) => RatingModel(
        rating: json["rating"].toDouble(),
      );

  Map<String, dynamic> toJson() => {
        "rating": rating,
      };
}
