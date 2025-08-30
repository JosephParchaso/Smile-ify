function generateUniqueUsername(lastName, firstName, existingUsernames = []) {
    let usernameBase = lastName + '_' + firstName.charAt(0).toUpperCase();
    let username = usernameBase;
    let counter = 0;

    while (existingUsernames.includes(username)) {
        counter++;
        username = usernameBase + counter;
    }

    return username;
}
