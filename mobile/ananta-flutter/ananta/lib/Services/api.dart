import 'dart:convert';
import 'dart:io';
import 'package:ananta/Model/food.dart';
import 'package:http/http.dart' as http;

class FoodAllApi {
  static Future<List<FoodModel>> getFood(String token) async {
    final response = await http.get(
      Uri.parse('http://10.0.2.2:8000/api/allfood'),
      // Send authorization headers to the backend.
      headers: {
        HttpHeaders.authorizationHeader:
            'Bearer 2|8VAsNkyPIhFs0LopPaPZ4iEQpkj0GWDZxNK1ONJK',
      },
    );

    Iterable List = json.decode(response.body);

    return List.map((json) => FoodModel.fromJson(json)).toList();
  }

  static Future<List<FoodModel>> getOneFood(String token) async {
    final response = await http.post(
      Uri.parse('http://10.0.2.2:8000/api/onefood'),
      // Send authorization headers to the backend.
      headers: {
        HttpHeaders.authorizationHeader:
            'Bearer 2|8VAsNkyPIhFs0LopPaPZ4iEQpkj0GWDZxNK1ONJK',
      },
      body: {'id': 15},
    );

    final List foods = json.decode(response.body);

    return foods.map((json) => FoodModel.fromJson(json)).toList();
  }
}

class FoodAllApiTest {
  static Future getFood() async {
    final response = await http.get(
      Uri.parse('http://10.0.2.2:8000/api/allfood'),
      // Send authorization headers to the backend.
      headers: {
        HttpHeaders.authorizationHeader:
            'Bearer 2|8VAsNkyPIhFs0LopPaPZ4iEQpkj0GWDZxNK1ONJK',
      },
    );
    print(json.decode(response.body));
  }
}
