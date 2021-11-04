class User {
  int account_id;
  String username;
  int role;

  User({
    this.account_id = 0,
    this.username = '',
    this.role = 0,
  });

  User.fromJson(Map<String, dynamic> json)
      : account_id = json['account_id'],
        username = json['username'],
        role = json['role'];
}
