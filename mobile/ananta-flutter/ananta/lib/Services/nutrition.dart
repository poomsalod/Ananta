import 'dart:io';
import 'package:ananta/Model/dayEat.dart';
import 'package:ananta/Model/history.dart';
import 'package:ananta/Model/nutrition.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

class NutritionPro extends ChangeNotifier {
  List<Nutrition> nutri = [];

  List<Nutrition> getNutri() {
    return nutri;
  }

  addNutri(Nutrition item) {
    nutri.add(item);
  }

  void fetchNutrition({required String token, required int userId}) async {
    if (token == '') {
      return;
    } else {
      try {
        nutri = [];

        Map creds = {'user_id': userId.toString()};

        final response = await http.post(
            Uri.parse('http://10.0.2.2:8000/api/user/nutrition'),
            // Send authorization headers to the backend.
            headers: {
              HttpHeaders.authorizationHeader: 'Bearer $token',
            },
            body: creds);
        Iterable list = json.decode(response.body);
        nutri = list.map((model) => Nutrition.fromJson(model)).toList();
        // nutri.add(Nutrition.fromJson(json.decode(response.body)));
        print('nutrition ok');

        notifyListeners();
      } catch (e) {
        print(e);
      }
    }
  }
}
