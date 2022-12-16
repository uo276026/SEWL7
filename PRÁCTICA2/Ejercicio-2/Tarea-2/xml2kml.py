import xml.etree.ElementTree as ET
import codecs
import os
THIS_FOLDER = os.path.dirname(os.path.abspath(__file__))

class Kml(object):
    def __init__(self):
        self.root = ET.Element('kml')
        self.doc = ET.SubElement(self.root, "Document")

    def add_placemark(self,name,lat,long,alt):
        pm = ET.SubElement(self.doc,"Placemark")
        ET.SubElement(pm,"name").text = name
        pt = ET.SubElement(pm,'Point')
        ET.SubElement(pt,"coordinates").text = '{},{},{}'.format(lat, long, alt)

    def write(self,filename):
        tree = ET.ElementTree(self.root)
        tree.write(filename)

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
    kml=Kml()
    for hijo in raiz.findall('.//'):
        if hijo.tag=="lugarNacimiento":
            for lugar in hijo:
                for nombreLugar in lugar:
                    kml.add_placemark(nombreLugar.text, lugar.attrib.get("latitud"), lugar.attrib.get("longitud"), lugar.attrib.get("altitud"))
        if hijo.tag=="lugarResidencia":
            for lugar in hijo:
                for nombreLugar in lugar:
                    kml.add_placemark(nombreLugar.text, lugar.attrib.get("latitud"), lugar.attrib.get("longitud"), lugar.attrib.get("altitud"))
                    
    kml.write(os.path.join(THIS_FOLDER,"redsocial.kml"))




def main():
    transform(os.path.join(THIS_FOLDER,"redsocial.xml"))

main()
