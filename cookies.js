class Cookie {
  #cookies;

  constructor() {
    this.cookies = {};
  }

  /* This method splits and re-splits the cookie received */
  readCookie(name) {
    /* Splitting every element */
    let members = name.split(";");

    /* Looping through, splitting and creating the dictionary element */
    for (var i=0; i<members.length; i++) {
      let raw_cookies = members[i].split('=');
      this.cookies[raw_cookies[0].trim()] = raw_cookies[1];
    }
  }

  search(value) {
    return this.cookies[value];
  }

  get cookie() {
    return this.cookies;
  }
}
