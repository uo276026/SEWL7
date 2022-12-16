import xml.etree.ElementTree as ET
import codecs
import os
import fileinput
import sys

THIS_FOLDER = os.path.dirname(os.path.abspath(__file__))
archivoXML=os.path.join(THIS_FOLDER,"library.xml")

def mostrarContenido():
    f = open(archivoXML, "r")
    lines=f.read()
    tree = ET.fromstring(lines.strip())

    if(tree.tag=="set"):
        for elem in tree:
            getInfo(elem, "")
    f.close()
    start()
            
def getInfo(elem, tabulador):
     if elem.tag == "book":
        print(tabulador+"Libro:")
        getDatos(elem, tabulador+"\t")
     elif elem.tag=="article":
        print(tabulador+"Articulo:")
        getDatos(elem,tabulador+"\t")

def getDatos(elem, tabulador):
    print(tabulador+"Titulo: "+getTitle(elem))
    for datos in elem:
        if (datos.tag=="chapter"):
            print(tabulador+"Capitulo: "+getChapter(datos, tabulador+tabulador))
        elif (datos.tag=="part"):
             print(tabulador+"Parte: "+getTitle(datos))
             for datos2 in datos:
                if(datos2.tag=="chapter"):
                    print(tabulador+tabulador+"Capitulo: "+getChapter(datos2, tabulador+tabulador+tabulador))
        elif(datos.tag=="para"):
            print(tabulador+'"'+datos.text+'"')
        elif(datos.tag=="author"):
            getAuthor(datos,tabulador);
        elif(datos.tag=="publisher"):
            getPublisher(datos, tabulador)
        elif(datos.tag=="pubdate"):
            print(tabulador+"Fecha de Publicación: "+datos.text)
        getInfo(datos, tabulador)

def getPublisher(publisher, tabulador):
    for datos in publisher:
        if(datos.tag=="publishername"):
            print(tabulador+"Editor: "+datos.text)
        elif datos.tag=="address":
            for calle in datos:
                if (calle.tag=="street"):
                    print(tabulador+"Oficina del editor: " +calle.text)
  

def getAuthor(autor, tabulador):
    firstName=""
    lastName=""
    for datos in autor:
        if(datos.tag=="firstname"):
            firstName=datos.text
        elif datos.tag=="surname":
            lastName=datos.text
    print(tabulador+"Autor: "+firstName+" "+lastName)

def getChapter(chapter, tabulador):
    text=""" """
    text=(getTitle(chapter))
    for i in chapter:
        if(i.tag == "para"):
            text+="\n"+tabulador+'"'+i.text+'"'

    return text

def getTitle(elemento):
    for title in elemento:
        if(title.tag == "title"):
            return title.text
    return "'Sin titulo registrado'"
            

    
def añadirLibro(): 
    print("¿Cual es el titulo del libro?")
    titulo=input();
    print("¿Cual es el nombre (sin apellidos) del autor?")
    nombre=input();
    print("¿Cual es el apellido del autor?")
    apellidos=input();

    string="""  <book>
    <title>"""+titulo+"""</title>
    <author>
        <firstname>"""+nombre+"""</firstname>
        <surname>"""+apellidos+"""</surname>
    </author>"""

    string= añadirParte(string, titulo)
    

    string+="""
  </book>
</set>"""
    
    for line in fileinput.FileInput(archivoXML, inplace=1):
        if('</set>' in line):
            line=line.replace(line, string)
        sys.stdout.write(line)
        
    start()

def añadirParte(string, tituloLibro):
    print('|    Libro '+'"'+tituloLibro+'"')
    print('+----------------------------------------------------------------+')
    print('|    --> 1 Añadir parte.                                         |')
    print('|    --> 2 Salir                                                 |')
    print('+----------------------------------------------------------------+')
    opcion = 3
    while(opcion!="1" and opcion!="2"):
        opcion=input()
        if opcion=="1":
            print("¿Cual es el titulo de la parte del libro?")
            tituloParte=input();
            string+="""
    <part>
        <title>"""+tituloParte+"""</title>"""
            string=añadirCapitulo(string, tituloParte)
            string+="""
    </part>"""
            string=añadirParte(string, tituloLibro)
    return string

def añadirCapitulo(string, tituloParte):
    
    opcion="3"
    print('|    Parte '+'"'+tituloParte+'"')
    print('+----------------------------------------------------------------+')
    print('|    --> 1 Añadir capitulo.                                      |')
    print('|    --> 2 Salir                                                 |')
    print('+----------------------------------------------------------------+')
    while(opcion!="1" and opcion!="2"):
        opcion = input()
        if opcion=="1":
            print("¿Cual es el titulo del capitulo?")
            tituloCapitulo=input()
            string+="""
        <chapter>
            <title>"""+tituloCapitulo+"""</title>"""
            string=añadirParrafo(string, tituloCapitulo)
            string+="""
        </chapter>"""
            string=añadirCapitulo(string, tituloParte)
    return string
            
    

def añadirParrafo(string, tituloCapitulo):
    print('|    Capitulo '+'"'+tituloCapitulo+'"')
    print('+----------------------------------------------------------------+')
    print('|    --> 1 Añadir parrafo.                                       |')
    print('|    --> 2 Salir                                                 |')
    print('+----------------------------------------------------------------+')
    opcion="3"
    while(opcion!="1" and opcion!="2"):
        opcion = input()
        if opcion=="1":
            print("Escriba el parrafo:")
            parrafo=input()
            string+="""
            <para>"""+parrafo+"""</para>"""
            string=añadirParrafo(string, tituloCapitulo)
    return string



def añadirArticulo():
    print()
    
def start():
        print('+----------------------------------------------------------------+')
        print('|    ¿Que desea hacer?                                           |')
        print('|    --> 1 Añadir libro.                                         |')
        print('|    --> 2 Mostrar libros y articulos                            |')
        print('|    --> 3 Salir                                                 |')
        print('+----------------------------------------------------------------+')
        opcion = input()
        while(opcion!="1" and opcion!="2" and opcion!="3"):
            opcion = input()
        if (opcion=="1"):
            añadirLibro()
        elif (opcion=="2"):
            mostrarContenido()
        elif (opcion=="3"):
            exit()


def main():
    start();

main()
