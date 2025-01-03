
Las solicitudes deben empezar con:
http://localhost/Tp-parte3/Tp-Parte3/api/


Endpoints
1. Obtener todos los clubes
GET /api/clubes
Este endpoint devuelve una lista de todos los clubes registrados en la base de datos.

Parámetros opcionales:
liga (string): Filtra los clubes por liga. Si no se proporciona, se devuelven todos los clubes.
orderBy (string): Especifica el orden de los resultados. Puede ser 'asc' o 'desc'.
orderCamp (string): El campo por el cual se ordenan los resultados. Puede ser 'Club' o 'Liga'.

Ejemplo de solicitud:

GET /api/clubes?liga=Espana&orderBy=asc&orderCamp=Club
Ejemplo de respuesta:

[
  {
    "id": 1,
    "Club": "Boca Juniors",
    "Liga": "Argentina"
  },
  {
    "id": 2,
    "Club": "Real Madrid CF",
    "Liga": "Espana"
  }
]
2. Obtener un club por ID
GET /api/clubes/{id}
Este endpoint devuelve un único club basado en su id.

Parámetros:
id (int): El identificador único del club.
Ejemplo de solicitud:

GET /api/clubes/1
Ejemplo de respuesta::

{
  "id": 1,
  "Club": "Boca Juniors",
  "Liga": "Argentina"
}
3. Agregar un nuevo club
POST /api/clubes
Este endpoint permite agregar un nuevo club a la base de datos.

Parámetros:
Club (string): El nombre del club.
Liga (string): La liga a la que pertenece el club:
Ejemplo de solicitud:

POST /api/clubes

{
  "Club": "Juventus",
  "Liga": "Italia"
}

Ejemplo de respuesta:

{
  "id": 27,
  "Club": "Juventus",
  "Liga": "Italia"
}

4. Editar un club
PUT /api/clubes/{id}
Este endpoint permite editar los detalles de un club existente.

Parámetros:
id (int): El identificador del club.
Club (string): El nombre del club a actualizar.
Liga (string): La liga a la que pertenece el club.
Ejemplo de solicitud:


PUT /api/clubes/1


{
  "Club": "Boca Juniors",
  "Liga": "Argentina"
}

Ejemplo de respuesta:

{
  "id": 1,
  "Club": "Boca Juniors",
  "Liga": "Argentina"
}
5. Eliminar un club
DELETE /api/clubes/{id}
Este endpoint elimina un club de la base de datos.

Parámetros:
id (int): El identificador único del club a eliminar.
Ejemplo de solicitud:


DELETE /api/clubes/1

Ejemplo de respuesta:

{
  "message": "Club eliminado con éxito"
}


JUGADORES

1. Obtener todos los jugadores
GET /api/jugadores
Este endpoint devuelve una lista de todos los jugadores registrados en la base de datos.

Parámetros opcionales:
club (int): Filtra los jugadores por id_club. Si no se proporciona, se devuelven todos los jugadores.
orderBy (string): Especifica el orden de los resultados. Puede ser 'asc' o 'desc'.
orderCamp (string): El campo por el cual se ordenan los resultados. Puede ser 'Nombre', 'Posicion' o 'Nacimiento'.

Ejemplo de solicitud:

GET /api/jugadores?club=1&orderBy=asc&orderCamp=Nombre

Ejemplo de respuesta:

[
  {
    "id": 1,
    "Nombre": "Carlos Tevez",
    "Posicion": "Delantero",
    "Nacimiento": "1984-02-05",
    "id_club": 1
  },
  {
    "id": 2,
    "Nombre": "Diego Maradona",
    "Posicion": "Delantero",
    "Nacimiento": "1960-10-30",
    "id_club": 1
  }
]
2. Obtener un jugador por ID
GET /api/jugadores/{id}
Este endpoint devuelve un único jugador basado en su id.

Parámetros:
id (int): El identificador único del jugador.
Ejemplo de solicitud:


GET /api/jugadores/1

Ejemplo de respuesta:

{
  "id": 1,
  "Nombre": "Carlos Tevez",
  "Posicion": "Delantero",
  "Nacimiento": "1984-02-05",
  "id_club": 1
} 

3. Agregar un nuevo jugador
POST /api/jugadores
Este endpoint permite agregar un nuevo jugador a la base de datos.

Parámetros:
Nombre (string): El nombre del jugador.
Posicion (string): La posición en la que juega.
Nacimiento (date): La fecha de nacimiento.
id_club (int): El identificador del club al que pertenece el jugador.
Ejemplo de solicitud:


POST /api/jugadores

{
  "Nombre": "Lionel Messi",
  "Posicion": "Delantero",
  "Nacimiento": "1987-06-24",
  "id_club": 1
}

Ejemplo de respuesta:

{
  "id": 3,
  "Nombre": "Lionel Messi",
  "Posicion": "Delantero",
  "Nacimiento": "1987-06-24",
  "id_club": 1
}

4. Editar un jugador
PUT /api/jugadores/{id}
Este endpoint permite editar los detalles de un jugador existente.

Parámetros:
id (int): El identificador del jugador.
Nombre (string): El nombre del jugador a actualizar.
Posicion (string): La posición en la que juega.
Nacimiento (date): La fecha de nacimiento.
id_club (int): El identificador del club al que pertenece el jugador.
Ejemplo de solicitud:


PUT /api/jugadores/1

{
  "Nombre": "Carlos Tevez",
  "Posicion": "Delantero",
  "Nacimiento": "1984-02-05",
  "id_club": 1
}

Ejemplo de respuesta:

{
  "id": 1,
  "Nombre": "Carlos Tevez",
  "Posicion": "Delantero",
  "Nacimiento": "1984-02-05",
  "id_club": 1
}
5. Eliminar un jugador
DELETE /api/jugadores/{id}
Este endpoint elimina un jugador de la base de datos.

Parámetros:
id (int): El identificador único del jugador a eliminar.
Ejemplo de solicitud:


DELETE /api/jugadores/1
Ejemplo de respuesta:

{
  "message": "Jugador eliminado con éxito"
}

Códigos de estado HTTP
200 OK: La solicitud se ha procesado correctamente.
201 Created: El recurso se ha creado correctamente.
400 Bad Request: La solicitud no es válida o faltan parámetros.
404 Not Found: No se ha encontrado el recurso solicitado.
500 Internal Server Error: Error en el servidor al procesar la solicitud.