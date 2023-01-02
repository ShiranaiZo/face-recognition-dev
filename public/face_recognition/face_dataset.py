''''
Capture multiple Faces from multiple users to be stored on a DataBase (dataset directory)
	==> Faces will be stored on a directory: dataset/ (if does not exist, pls create one)
	==> Each face will have a unique numeric integer ID as 1, 2, 3, etc

Based on original code by Anirban Kar: https://github.com/thecodacus/Face-Recognition

Developed by Marcelo Rovai - MJRoBot.org @ 21Feb18

'''

import cv2
import os
import sys

cam = cv2.VideoCapture(0, cv2.CAP_DSHOW)
cam.set(cv2.CAP_PROP_FRAME_WIDTH, 640) # set video width
cam.set(cv2.CAP_PROP_FRAME_HEIGHT, 480) # set video height

face_detector = cv2.CascadeClassifier(sys.argv[1]+'/face_recognition/haarcascade_frontalface_default.xml')
eyeDetector = cv2.CascadeClassifier(sys.argv[1]+'/face_recognition/haarcascade_eye.xml')

# For each person, enter one numeric face id
# face_id = input('\n enter user id end press <return> ==>  ')

# print("\n [INFO] Initializing face capture. Look the camera and wait ...")
# Initialize individual sampling face count
count = 0

while(True):

    ret, img = cam.read()
    # flip video image vertically
    # img = cv2.flip(img, -1)
    gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
    faces = face_detector.detectMultiScale(gray, 1.3, 5)

    for (x,y,w,h) in faces:

        if count >= 30:
            img = cv2.rectangle(img, (0,0), (0,0), (0,255,255), 2)

            roiabuabu = gray[y:y + h, x:x + w]
            roiwarna = img[y:y + h, x:x + w]
            eyes = eyeDetector.detectMultiScale(roiabuabu)
            for (xe, ye, we, he) in eyes:
                cv2.rectangle(roiwarna, (0, 0), (0, 0), (0, 255, 255), 1)
        else:
            img = cv2.rectangle(img, (x,y), (x+w,y+h), (0,255,255), 2)

            roiabuabu = gray[y:y + h, x:x + w]
            roiwarna = img[y:y + h, x:x + w]
            eyes = eyeDetector.detectMultiScale(roiabuabu)
            for (xe, ye, we, he) in eyes:
                cv2.rectangle(roiwarna, (xe, ye), (xe + we, ye + he), (0, 255, 255), 1)


        # Save the captured image into the datasets folder
        cv2.imwrite(sys.argv[1]+"/face_recognition/datasementara/"+sys.argv[2] + '.' + str(count) + ".jpg", img)

        count += 1

        cv2.imshow('image', img)


    k = cv2.waitKey(100) & 0xff # Press 'ESC' for exiting video
    if k == 27:
        break
    elif count >= 31: # Take 30 face sample and stop video
        break

# Do a bit of cleanup
print(sys.argv[2])
cam.release()
cv2.destroyAllWindows()


