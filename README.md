# calculator-task
Simple calculator task


Task description
----------------

- Stáhněte aktuální Nette\Sandbox přes composer

- Vytvořte Presenter, který bude dostupný na URL/test-issue s tím, že presenter bude umět přijímat jeden nepovinný parametr value, který může obsahovat jakýkoliv znak.

- Vytvořte komponentu, která bude obsahovat formulář s textareou a submit tlačítkem, po odeslání formuláře dojde k spočítání příkladu a vypsání výsledku. Pokud nebude parameter valueprázdný, tak provedete obdobnou akci jako při odeslání formuláře.

- Výstupem bude správný výsledek výrazu. Algoritmus bude podporovat součet (+), rozdíl (-) a závorky (neomezený počet zanoření). Vyhodnocení výrazu musí provést váš algoritmus, nikoliv PHP (pomocí eval()) ani žádná externí služba.

- Příklad vstupu: 6 * ((26 / 2) + -3) – 20)

Implementation
--------------

For easier execution implemented using docker. Start application by command


    docker-compose up
    
Find out the ip using:

    docker-machine ip
    
And open up in a browser (using port 8090, for instance)

    http://192.168.99.100:8090/           

It can be of course started without docker as well.
Requirements:
- PHP 7.1+
- apache (with mod_rewrite)
- composer installed

Before opening the site run:
    
    composer install

Tests
-----

Tests can be executed running:

    docker exec -ti calculatortask_apache_1 sh -c "vendor/bin/tester tests"
    
Or without docker simply running:

    ./tests.sh 
    
Note
----
 
Given input: '6 * ((26 / 2) + -3) – 20)' is invalid (extra bracket). 
Mutliplication and division was not in scope but was implemented as well. 
The algorithm uses partial recursion. 