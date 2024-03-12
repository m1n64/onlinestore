import moment from "moment/moment";

export const isImageByMimeType = (mimeType) => /image\/.*/.test(mimeType);
export const isVideoByMimeType = (mimeType) => /video\/.*/.test(mimeType);
export const isAudioByMimeType = (mimeType) => /audio\/.*/.test(mimeType);

export const openInNewTab = (url) => {
    window.open(url, '_blank', 'noreferrer');
};

export const formatDate = (date) => moment(date).format("Y.D.M HH:mm:ss");
