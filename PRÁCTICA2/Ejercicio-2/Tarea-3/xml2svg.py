import xml.etree.ElementTree as ET
import codecs
import os
THIS_FOLDER = os.path.dirname(os.path.abspath(__file__))

WIDTH = 2800
HEIGHT = 3000
Y_INC = 400
FONT_SIZE = 20


def transform(archivoXML, svgFile):
        try:
            arbol = ET.parse(archivoXML)
        except IOError:
            print("No se encuentra el archivo ", archivoXML)
            exit()
        except ET.ParseError:
            print("Error procesando en el archivo XML = ", archivoXML)
            exit()

        svg = '''<svg version="1.1" xmlns="http://www.w3.org/2000/svg"
            width="%dpx" height="%dpx" viewBox="0 0 %d %d">%s
            <style><![CDATA[
            text{
                dominant-baseline: middle;
                text-anchor: middle;
                font: %s Verdana, Helvetica, Arial, sans-serif;
            }
            line {
                stroke:rgb(0,0,0);
                stroke-width:2;
            }
            ]]></style>
        </svg>
            '''
    
        raiz = arbol.getroot()
        generated_svg = rec(raiz, HEIGHT/2, FONT_SIZE, 1)
        svg = svg % (WIDTH, HEIGHT, WIDTH, HEIGHT, generated_svg, FONT_SIZE)
        
        svgFile.write(svg)
        svgFile.close()
        

def rec(raiz, x, y, i, ans=''):
    
        if (not raiz):
            return ans

        person = person2svg(raiz, x, y)
        ans += person[0]
        i += 1
        y1 = y + Y_INC
        y = y + (person[1] + 7) * FONT_SIZE + 10
        times=1

        if(i==1):
         aux = 1
        elif (i==2):
         aux = 1.1
        else:
         aux = 0.7
   
        for hijo in raiz:
             if hijo.tag == "amigos":
                for amigo in hijo:
                   if amigo.tag == "persona":
                        if(times==1):
                           x1 = x - HEIGHT/(1.95**i)*aux
                        elif (times==2):
                           x1 = x 
                        else:
                            x1 = x + HEIGHT/(1.95**i)*aux
                            
                        ans += line_generator(x, y, x1, y1)
                        ans += rec(amigo, x1, y1, i)
                        times+=1
                       
            
       
        return ans

def person2svg(raiz, x, y, aux=''):
        text = lambda x,y,z,a: '\n\t\t<text x="%d" y="%d" %s> %s </text>' % (x,y,z,a)
        y_calc = lambda x: y + x * FONT_SIZE + 1

        aux += '\n\t<g>'

        aux += text(x,y_calc(1),'font-weight="bold"',(raiz.attrib.get("nombre") + ' ' + raiz.attrib.get("apellidos")))
        aux += text(x,y_calc(2),'',('Fecha Nacimiento: ' + raiz.attrib.get("fechaNacimiento")))
        aux += text(x,y_calc(4),'font-style="italic"',(raiz.attrib.get("comentario")))

        i = -3
        for hijo in raiz:
            if hijo.tag == "lugarNacimiento":
                for lugar in hijo:
                     i += 3
                     for nombreLugar in lugar:
                        aux += text(x,y_calc(6 + i),'',('Lugar Nacimiento: ' + nombreLugar.text))
                        aux += text(x,y_calc(7 + i),'',('Coordenadas: ' + lugar.attrib.get("latitud") +" "+ lugar.attrib.get("longitud")+" "+ lugar.attrib.get("altitud")))
            if hijo.tag == "lugarResidencia":
                 for lugar in hijo:
                     i += 3
                     for nombreLugar in lugar:
                        aux += text(x,y_calc(6 + i),'',('Lugar Residencia: ' + nombreLugar.text))
                        aux += text(x,y_calc(7 + i),'',('Coordenadas: ' + lugar.attrib.get("latitud") +" "+ lugar.attrib.get("longitud")+" "+ lugar.attrib.get("altitud")))           
                    
        aux += '\n\t</g>'

        return aux, i


def line_generator( x1, y1, x2, y2, aux=''):
     aux += '\n\t<line x1="%d" y1="%d" x2="%d" y2="%d" />' % (x1, y1, x2, y2-FONT_SIZE)
     return aux
   

def main():
    svgFile = codecs.open(os.path.join(THIS_FOLDER,"redsocial.svg"), "w", "utf-8")
    transform(os.path.join(THIS_FOLDER,"redsocial.xml"), svgFile)

main()
