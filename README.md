# simple_unit_test

Imagine you have written a program that does a simple calculation, say, computeing the area
of a hexagon. You run it and it gives you the area -34.56. you just know that that's wrong. 
Why? Because no shape has a negative area. So, you fix that bug (whatever it was) and 
get 51.452673. Is that right? That's harder to say because we don't usually keep the 
formula of a hexagon in our heads. What we must do before keeping fooling ourselves
is just to check that the answer is plausible. In this case, that's easy. A hexagon
is much like a square. We scribble our regular hexagon on a piece of paper and eyeball
it to be the size of a 3-by-3 square. such a square has the area 9. Bummer, our 51.452673
can't be right! So we work over our program again and get 10.3923. Now that just might be 
right!

The general point is not about areas. The point is that unless we have some idea of 
what a correct answer will be like, we don't have a clue whether our result is reasonable.

Does a unit test help to develop better code? Not really, the bottom line is that the code 
and the test cases depend on the skills of the developer. In other words, as far as one
does not use the relevant test cases, it does not matter if one is using the super fancy 
unit test out there or the "can you hear me?" approach.

Why over http? It is highly probably you are developing a web application, therefore server 
configuration is a criteria to be considered.

No need to extend any class, just:
define your autoloader function,
create a Test object with the relevant parameters
For any method of your class, set the test data to be used for testing 
define the assertion function to be used otherwise simple comparison is used
run the test!

Ability to test private or public methods
Ability to define dummies object with custom return values

More than attempt to be an exhaustive unit test, simple unit test is a proof of the concept.
The concept simple unit test is proving is that testing should be simple, straight forward,



