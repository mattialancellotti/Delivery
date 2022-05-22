DELIVERY
--------

### Introduction
This was a school project whose objective was to create a "fake" Amazon by
analyzing the problem, documenting it and then creating the actual service. No
technologies or languages were requested, it just had to be done.  

To make it I first decided to implement a REST API using JS/HTML/CSS for the
Front-End, PHP for the Back-End and MySQL as DBMS.


### Requests
The requests were pretty simple, the user had to be able to order something and
track the package (the tracking algorithm was not implemented, but the idea was
that the package usually should have gone through multiple cities before
reaching its destination) and this package could also come from another client.  
Obviously a login system had to be implemented and the last request was to
integrate a SSO from Google (I removed the ID and the Secret from the code so it
wil never work).

### How it works
I chose a REST API so it's actually pretty simple to understand how it works. On
user interaction the front-end will contact (by fetching in javascript) the
correspondent PHP page (that could accept parameters), which most of the time
will return a JSON response for the front-end to parse. Since the deadline was
coming a coulnd't implement things like configuration files or parameters
checking to prevent SQL Injections.
