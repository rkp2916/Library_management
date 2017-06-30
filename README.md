# Library_management
The Library Management System works on the given set of a requirements.
1. The library records information about books that are available in its system. Each book is identified by a unique number (BookId.) It also has a title, author, an ISBN, a publisher, and a publication date.
2. Each book has a single publisher and the publisher address is also recorded.
3. Information about the authors of books is maintained. An author is identified by a number
(AuthorId.) The name of each author is also recorded.
4. The library system contains several branches, which are identified by a number (LibId). We
also need to store the name and the location of each branch. Each branch of the library holds a number of copies of a particular book. Each copy of the same book kept by the same library branch is numbered from 1 to n. The total number of copies of each book in the library is needed.
5. The library system keeps track of all readers who are uniquely identified by ReaderId. Each reader has a name, an address, and a phone number. A reader has to be registered in the database before borrowing a document.
6. Readers have access to the online catalogue of books and may reserve books by title if they are available. A reserved book has to be picked up before 6 pm; otherwise, the reservation is cancelled. A reader cannot borrow or reserve more than 10 books.
7. Borrowing is defined as taking out a copy of a book on one date and time (BDateTime) and returning it a maximum of 20 days later. RDateTime is the date and time on which the copy of the borrowed book is actually returned. (RDateTime is NULL if the document has not yet been returned). Books have to be returned to the branch from which they are borrowed.
8. The same copy of a book can be reserved and/or borrowed by the same reader several times.
9. Books that are not returned on time are fined at a rate of 20 cents for each day after the due
date.
10. A copy of a book cannot be lent to more than one reader at a time, but a reader can borrow
multiple copies of books.

In addition to the above in the library system user can find the book based on a keyword, image of the  front page and book front pages can be stored too. 

Tools used to create the library system:
1. php and mysql for a backend 
2. AJAX, HTML, CSS, JavaScript, angular.js for the frontend and User Interface.

The library system can be implemented to more than one branches of the same library and it can be used for multiple libraries.
