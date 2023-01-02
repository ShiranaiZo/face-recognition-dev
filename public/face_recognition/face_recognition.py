''''
Real Time Face Recogition
	==> Each face stored on dataset/ dir, should have a unique numeric integer ID as 1, 2, 3, etc
	==> LBPH computed model (trained faces) should be on trainer/ dir
Based on original code by Anirban Kar: https://github.com/thecodacus/Face-Recognition

Developed by Marcelo Rovai - MJRoBot.org @ 21Feb18

'''

import cv2
import numpy as np
import os
import sys

recognizer = cv2.face.LBPHFaceRecognizer_create()
recognizer.read(sys.argv[1]+'/face_recognition/training/'+sys.argv[2]+'/trainer.yml')
cascadePath = sys.argv[1]+'/face_recognition/haarcascade_frontalface_default.xml'
faceCascade = cv2.CascadeClassifier(cascadePath)
output = False

font = cv2.FONT_HERSHEY_SIMPLEX

#iniciate id counter
id = 0


# Initialize and start realtime video capture
cam = cv2.VideoCapture(0, cv2.CAP_DSHOW)
cam.set(cv2.CAP_PROP_FRAME_WIDTH, 640) # set video widht
cam.set(cv2.CAP_PROP_FRAME_HEIGHT, 480) # set video height

# Define min window size to be recognized as a face
minW = 0.1*cam.get(3)
minH = 0.1*cam.get(4)

jumlah_terdeteksi = 0
jumlah_gagal = 0

while True:

    ret, img =cam.read()
    #img = cv2.flip(img, -1) # Flip vertically

    gray = cv2.cvtColor(img,cv2.COLOR_BGR2GRAY)

    faces = faceCascade.detectMultiScale(
        gray,
        scaleFactor = 1.2,
        minNeighbors = 5,
        minSize = (int(minW), int(minH)),
    )

    for(x,y,w,h) in faces:

        # cv2.rectangle(img, (x,y), (x+w,y+h), (0,255,0), 2)

        id, confidence = recognizer.predict(gray[y:y+h,x:x+w])

        # Check if confidence is less them 100 ==> "0" is perfect match
        if (confidence < 50):
            id = 'Terdeteksi'

            confidence = "  {0}%".format(round(140-confidence))

            jumlah_terdeteksi += 1

        else:
            id = "Tidak Terdeteksi"
            confidence = "  {0}%".format(round(100 - confidence))

            jumlah_gagal += 1

        cv2.putText(img, str(id), (x+5,y-5), font, 1, (255,255,255), 2)
        cv2.putText(img, str(confidence), (x+5,y+h-5), font, 1, (255,255,0), 1)


    cv2.imshow('camera',img)

    k = cv2.waitKey(10) & 0xff # Press 'ESC' for exiting video
    if k == 27:
        break
    elif jumlah_terdeteksi >= 30: # Take 30 face sample and stop video
        output = True
        break
    elif jumlah_gagal >= 100:
        output = False
        break


# Do a bit of cleanup
print(output)

cam.release()
cv2.destroyAllWindows()
