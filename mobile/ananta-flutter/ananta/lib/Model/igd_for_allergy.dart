import 'dart:convert';

List<IgdModal> igdModalFromJson(String str) =>
    List<IgdModal>.from(json.decode(str).map((x) => IgdModal.fromJson(x)));

String igdModalToJson(List<IgdModal> data) =>
    json.encode(List<dynamic>.from(data.map((x) => x.toJson())));

class IgdModal {
  IgdModal({
    required this.igdInfoId,
    required this.name,
    required this.image,
    required this.cateIgdId,
  });

  int igdInfoId;
  String name;
  String image;
  int cateIgdId;

  factory IgdModal.fromJson(Map<String, dynamic> json) => IgdModal(
        igdInfoId: json["igd_info_id"],
        name: json["name"],
        image: json["image"],
        cateIgdId: json["cate_igd_id"],
      );

  Map<String, dynamic> toJson() => {
        "igd_info_id": igdInfoId,
        "name": name,
        "image": image,
        "cate_igd_id": cateIgdId,
      };
}
