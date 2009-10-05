<?php

$mov = new ffmpeg_movie(dirname(__FILE__) . '/test_media/video.wmv');

echo "<pre>";
echo "getFrameCount : " . $mov->getFrameCount() . "\n";
echo "getPixelFormat(): " .  $mov->getPixelFormat() . "\n";
echo "getAudioBitRate(): " .  $mov->getAudioBitRate() . "\n";
echo "getAudioChannels(): " .  $mov->getAudioChannels() . "\n";
echo "getAudioCodec(): " .  $mov->getAudioCodec() . "\n";
echo "getAudioSampleRate(): " .  $mov->getAudioSampleRate() . "\n";
echo "getAudioStreamId(): " .  $mov->getAudioStreamId() . "\n";
echo "getBitRate(): " .  $mov->getBitRate() . "\n";
echo "getDuration(): " .  $mov->getDuration() . "\n";
echo "getFileName(): " .  $mov->getFileName() . "\n";
echo "getFrameRate(): " .  $mov->getFrameRate() . "\n";
echo "getFrameWidth(): " .  $mov->getFrameWidth() . "\n";
echo "getFrameNumber(): " .  $mov->getFrameNumber() . "\n";
echo "getFrameHeight(): " .  $mov->getFrameHeight() . "\n";
echo "getFrameCount(): " .  $mov->getFrameCount() . "\n";
echo "getVideoCodec(): " .  $mov->getVideoCodec() . "\n";
echo "getVideoBitRate(): " .  $mov->getVideoBitRate() . "\n";
echo "getPixelAspectRatio(): " .  $mov->getPixelAspectRatio() . "\n";
echo "getVideoStreamId(): " .  $mov->getVideoStreamId() . "\n";
printf("ffmpeg hasAudio(): %s\n", $mov->hasAudio() ? 'Yes' : 'No');
printf("ffmpeg getTitle(): %s\n", $mov->getTitle());
printf("ffmpeg getArtist(): %s\n", $mov->getArtist());
printf("ffmpeg getAlbum(): %s\n", $mov->getAlbum());
printf("ffmpeg getGenre(): %s\n", $mov->getGenre());
printf("ffmpeg getTrackNumber(): %s\n", $mov->getTrackNumber());
printf("ffmpeg getYear(): %s\n", $mov->getYear());
printf("ffmpeg getDuration(): %0.2f\n", $mov->getDuration());
echo "</pre>";

