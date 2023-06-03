#include <WiFi.h>
#include <ESPAsyncWebSrv.h>
#include <ArduinoJson.h>
#include <HTTPClient.h>

const char* ssid = "POCO X3 NFC";
const char* password = "123456780";
char* token = "";
AsyncWebServer server(80);

const int relayPin = 18;

void setup() {
  Serial.begin(115200);

  // Conectarse a la red WiFi
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Conectando a WiFi...");
  }

  // Configurar la ruta para recibir la solicitud HTTP y activar el relé
  server.on("/desactivar_rele", HTTP_GET, [](AsyncWebServerRequest *request){
    digitalWrite(relayPin, HIGH);
    request->send_P(200, "text/plain", "Relé activado");
  });

  server.on("/activar_rele", HTTP_GET, [](AsyncWebServerRequest *request){
    digitalWrite(relayPin, LOW);
    request->send(200, "text/plain", "Relé desactivado");
  });

  // Iniciar el servidor web
  server.begin();

  // Configurar el pin del relé como salida
  pinMode(relayPin, OUTPUT);
  digitalWrite(relayPin, HIGH);

  Serial.println("Servidor iniciado");
  Serial.println(WiFi.localIP());
}

void loop() {
    if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;

    // Especificar la URL de la API que deseas llamar
    http.begin("http://192.168.149.99/estado.php?id=2");
    // Realizar la solicitud GET
    int httpResponseCode = http.GET();

    // Verificar el código de respuesta
    if (httpResponseCode > 0) {
      String response = http.getString();


      if(response == "0") {
          digitalWrite(relayPin, HIGH);
      } else {
        digitalWrite(relayPin, LOW);
      }

      Serial.println("Respuesta recibida: " + response);
    } else {
      Serial.println("Error en la solicitud. Código de respuesta: " + String(httpResponseCode));
    }

    http.end();

    delay(1000); // Esperar 5 segundos antes de realizar la próxima solicitud
  }
}
