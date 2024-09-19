## Telefonkönyv
### Használt technológiák 
- PHP
- MySQL
- Docker
- Bootstrap
- JavaScript

### Előkövetelmények
- Docker Desktop telepítése a gépedre.

### Projekt futtatása

- Töltsd le vagy klónozd a projektet a gépedre:

```
git clone https://github.com/kulcsarbence/PhoneBook
```

A projekt gyökérkönyvtárában futtasd a következő parancsot a Docker konténerek felépítéséhez:

```
docker compose build
```
Docker konténerek indítása a háttérben

```
docker compose up -d
```

Nyisd meg a böngésződet, és nyisd be az alábbi URL-t:


```
http://localhost:8080
```
Ha le szeretnéd állítani a konténereket, futtasd az alábbi parancsot:

```
docker compose down
```

Adatmentés: Az adatbázis adatai a db_data nevű Docker volumenben kerülnek tárolásra.


Ha közvetlenül szeretnél csatlakozni az adatbázishoz pl. HeidiSQL-lel, azt megteheted a localhost:10006 porton, amely a docker-compose.yml-ben van definiálva.