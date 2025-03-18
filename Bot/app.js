const { createBot, createProvider, createFlow, addKeyword } = require('@bot-whatsapp/bot');
const QRPortalWeb = require('@bot-whatsapp/portal');
const BaileysProvider = require('@bot-whatsapp/provider/baileys');
const MockAdapter = require('@bot-whatsapp/database/mock');
const axios = require('axios');
const fs = require('fs');

// Función para obtener datos de la API y almacenarlos en un JSON
const fetchAndStoreData = async () => {
    try {
        const response = await axios.get('http://localhost:8081/codigos');
        fs.writeFileSync('data.json', JSON.stringify(response.data, null, 2));
        console.log('Datos almacenados correctamente en data.json');
    } catch (error) {
        console.error('Error al obtener los datos de la API:', error);
    }
};

// Función para cargar los datos desde el JSON
const loadData = () => {
    try {
        if (!fs.existsSync('data.json')) return []; // Si no existe el archivo, devuelve un array vacío
        const data = fs.readFileSync('data.json', 'utf8');
        return JSON.parse(data) || [];
    } catch (error) {
        console.error('Error al leer el archivo JSON:', error);
        return [];
    }
};
const menu = addKeyword('Estoy interesado en sus servicios')
    .addAnswer(
        `Gracias por comunicarte con nosotros. Por favor, selecciona un número para conocer más sobre nuestros servicios:\n\n` +
        `1️⃣ Plan Básico\n` +
        `2️⃣ Plan Golden\n` +
        `3️⃣ Códigos de registro`
    );

const basico = addKeyword("1").addAnswer("Nuestros servicios basicos son: Consultas médicas ilimitadas, Acceso a historial médico, Soporte 24/7")
const golden = addKeyword("2").addAnswer("Nuestros servicios Golden son: Consultas médicas ilimitadas, Acceso a historial médico, Soporte 24/7,")


const main = async () => {
    const adapterDB = new MockAdapter();
    const adapterProvider = createProvider(BaileysProvider);

    const flujoprincipal = addKeyword('3').addAction(async (ctx, { flowDynamic }) => {
        // Actualizar los datos antes de responder
        await fetchAndStoreData();
        const storedData = loadData();

        const messageResponse = storedData.length > 0
            ? storedData.map(doc => `Nombre: ${doc.name}\nEspecialización: ${doc.specialization}\nCódigo: ${doc.codigo}`).join('\n\n')
            : 'No hay datos disponibles';

        // Enviar el mensaje con los datos actualizados
        await flowDynamic(messageResponse);
    });

    const adapterFlow = createFlow([menu,flujoprincipal,basico,golden]);

    createBot({
        flow: adapterFlow,
        provider: adapterProvider,
        database: adapterDB,
    });

    QRPortalWeb();
};

main();