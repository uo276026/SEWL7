import xml.etree.ElementTree as ET
import codecs
import os
THIS_FOLDER = os.path.dirname(os.path.abspath(__file__))

def transform(archivoXML):
    try:
        arbol = ET.parse(archivoXML)
    except IOError:
        print("No se encuentra el archivo ", archivoXML)
        exit()
    except ET.ParseError:
        print("Error procesando en el archivo XML = ", archivoXML)
        exit()

    raiz = arbol.getroot()

    file = codecs.open(os.path.join(THIS_FOLDER,"redsocial.html"), "w", "utf-8")
    text = """<!DOCTYPE HTML>
    <html lang="es">
    <head>
    <meta charset="UTF-8">
    <title> Red Social </title>
    <meta name="author" content="Lara Fernández Méndez" />
    <meta name ="description" content ="Desarrollo de una red social" />
    <meta name ="keywords" content ="redsocial, amigos" />
    <meta name ="viewport" content ="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="estilo/estilo.css" />
    </head>

    <body>
        <header> <h1> RED SOCIAL </h1> </header>

    <main>"""
        
    text+=getPerson(raiz)
    text += """
        </main>
    </body>
</html>"""
    file.write(text)
    file.close()

def  getPerson(raiz):
    text = """

        <section>
            <h2>"""
    text+=raiz.attrib.get("nombre")+" "+raiz.attrib.get("apellidos")
    text+=""" </h2>
                <p> Fecha de nacimiento: """
    text+=raiz.attrib.get("fechaNacimiento")+"</p>"
    if raiz.attrib.get("comentario") != None:
        text+=("""
                <p>"""
        +raiz.attrib.get("comentario")+"</p>")
    if raiz.attrib.get("fotografia") != None:
        text+="""
                <img src="""+raiz.attrib.get("fotografia")+' alt=" Foto de perfil" />'
    
    for hijo in raiz:
        if hijo.tag == "lugarNacimiento":
            for lugar in hijo:
                for nombreLugar in lugar:
                    text+="""
                <p> Lugar Nacimiento:"""+ nombreLugar.text +"(Longitud "+lugar.attrib.get("longitud")+" - Altitud "+lugar.attrib.get("altitud")+ " - Latitud "+lugar.attrib.get("latitud")+")</p>"
        if hijo.tag == "lugarResidencia":
            for lugar in hijo:
                for nombreLugar in lugar:
                    text+="""
                <p> Lugar Residencia:"""+ nombreLugar.text +"(Longitud "+lugar.attrib.get("longitud")+" - Altitud "+lugar.attrib.get("altitud")+ " - Latitud "+lugar.attrib.get("latitud")+")</p>"
        if hijo.tag == "videos":
            once=True
            for video in hijo:
                if(once):
                    text+="""
                <p>Videos:</p>"""
                    once=False
                text+="""
                    <video src="""+ video.text +' controls preload="auto"></video>'
    text+="""
        </section>
        """
    for hijo in raiz:
        if hijo.tag == "amigos":
                for amigo in hijo:
                   if amigo.tag == "persona":
                       text+="  "+getPerson(amigo)
    
    return text




def main():
    transform(os.path.join(THIS_FOLDER,"redsocial.xml"))

main()
