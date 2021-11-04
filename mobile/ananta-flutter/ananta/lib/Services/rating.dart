import 'dart:io';
import 'package:http/http.dart' as http;
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';

class Rating extends ChangeNotifier {
  void addRating({required String token, required Map creds}) async {
    if (token == '') {
      return;
    } else {
      print(creds);
      try {
        final response =
            await http.post(Uri.parse('http://10.0.2.2:8000/api/addrating'),
                headers: {
                  HttpHeaders.authorizationHeader: 'Bearer $token',
                },
                body: creds);
        print(response.toString());

        notifyListeners();
      } catch (e) {
        print(e);
      }
    }
  }
}
