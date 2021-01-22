function hasGetUserMedia() {
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia)
        return true;
    else
        return false;
}
