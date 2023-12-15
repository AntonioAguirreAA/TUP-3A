"use strict";
const express = require('express');
const app = express();
app.set('puerto', 9876);
//RUTAS
app.get('/', (request, response) => {
    response.send('GET - servidor NodeJS');
});
app.listen(app.get('puerto'), () => {
    console.log('Servidor corriendo sobre puerto:', app.get('puerto'));
});
//# sourceMappingURL=servidor.js.map