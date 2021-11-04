class Profile {
  int user_id;
  String f_name;
  String l_name;
  String email;
  String image;
  String birthday;

  Profile({
    this.user_id = 0,
    this.f_name = '',
    this.l_name = '',
    this.email = '',
    this.image = '',
    this.birthday = '',
  });

  Profile.fromJson(Map<String, dynamic> json)
      : user_id = json['user_id'],
        f_name = json['f_name'],
        l_name = json['l_name'],
        email = json['email'],
        image = json['image'],
        birthday = json['birthday'];
}
