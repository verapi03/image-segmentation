# image-segmentation
The algorithm for the image segmentation implemented in this project is based on a clip-level (or a threshold value), which turns the image into a gray-scale one, keeping the red pixels as they appear on the original image.

On a high level view, the algorithm to perform the segmentation has the following steps:

1) The original image is obtained from the fileserver.
2) Its dimensions are calculated to loop over every single pixel in order to get its RGB color.
3) For the actual pixel on the loop, its color obtained in the previous step is decomposed into the three-vector RGB.
4) If the pixel has a color near to red (255, 0, 0), its color kepts the original value, otherwise an average color is calculated, which result in the gray tone that is assigned to the pixel.
5) When the loop finish, a JPEG file is created from the given image with the modified pixels' color.