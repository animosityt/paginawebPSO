# 蹴球 Cancha 6v6 ｜ Tabla de Promedios

<p align="center">
  <sub>( ˘ω˘ ) estadísticas del fuchi</sub>
</p>

![status](https://img.shields.io/badge/estado-activo-2f5233)
![type](https://img.shields.io/badge/tipo-HTML%20est%C3%A1tico-2f5233)
![license](https://img.shields.io/badge/licencia-MIT-2f5233)

---

## 概要 ｜ Descripción

Cada partido de la cancha grande genera un archivo de estadísticas (`MatchStats_*.txt`, JSON) con pases, tackles, intercepciones, atajadas y goles de cada jugador. Este proyecto toma esos datos, [...]

Es un proyecto chico, hecho por y para el grupo que juega. Nada de frameworks, un archivo, abrilo y listo.

## 特徴 ｜ Características

- **Arqueros y jugadores de campo, separados.** (ﾉ´ヮ`)ﾉ*: ･ﾟ si alguien atajó la mayoría de sus partidos, se lo compara contra otros arqueros — no contra delanteros.
- **Escala 78–99** calculada de forma independiente para cada tabla.
- Un solo archivo HTML, sin dependencias externas ni backend.
- Todo el cálculo corre en el navegador, en JavaScript plano.

## 方法論 ｜ Metodología

| Paso | Descripción |
|:---:|---|
| 1 | Se toman los archivos de los partidos más recientes — nunca los viejos. |
| 2 | Se calcula el promedio de `score` por jugador sobre esos partidos. |
| 3 | Si un jugador atajó en la mayoría de sus apariciones, pasa a la tabla de **Arqueros** y se excluyen sus partidos de campo (y viceversa). |
| 4 | Se interpola linealmente entre el mínimo y el máximo promedio **de cada tabla por separado**, sobre una escala de 78 (piso) a 99 (techo). Esto para que no quede algo de los que menos juega[...]

## 構成 ｜ Estructura

```
.
├── tabla_promedios.html   ── la página, un solo archivo
├── MatchStats_*.txt       ── stats crudas por partido (JSON)
└── README.md
```

---
## 連絡先 ｜ Contacto

¿Bug, sugerencia, o solo pasabas a saludar? ∘ ∘ ∘ ( °ヮ° ) ?✧
  
Por favor contactanos en GitHub:

| Plataforma | Usuario |
|:---------:|:-------|
| GitHub | [@animosityt](https://github.com/animosityt) |
| GitHub | [@AITOR_REX](https://github.com/aitor-byte) |

<table align="center"> <tr> <td align="center"> <a href="https://github.com/animosityt"> <img src="https://github.com/animosityt.png" width="90" style="border-radius:50%"><br> <sub><b>@animosityt</b></sub> </a> </td> <td align="center"> <a href="https://github.com/aitor-byte"> <img src="https://github.com/aitor-byte.png" width="90" style="border-radius:50%"><br> <sub><b>@AITOR_REX</b></sub> </a> </td> </tr> </table> <p align="center"> <sub>made with love (=｀ω´=) and too many horas mirando JSON de partidos de fulbito</sub> </p>
