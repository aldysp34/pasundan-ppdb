@props(['text' => true])

@if( $text )

<!-- <svg {!! $attributes !!} viewBox="0 0 354 85" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M44.6403 2.07902C49.7636 -1.5524 56.9417 -0.374183 59.828 5.20299C65.6087 16.3729 68.8738 29.0551 68.8738 42.5C68.8738 55.9449 65.6086 68.6271 59.828 79.797C56.9417 85.3742 49.7635 86.5524 44.6402 82.921C39.5107 79.2852 38.4222 72.2049 41.0008 66.4707C41.5962 65.1467 42.1253 63.7993 42.6349 62.4405C44.1635 58.2234 41.3054 53.8835 36.9173 52.9532C32.523 52.0215 28.2764 54.8815 26.5193 59.0156C24.6739 63.3567 22.1238 67.3257 19.0118 70.7787C17.9186 71.9918 16.756 73.1412 15.5304 74.2207C10.8222 78.3676 3.87769 75.9362 1.12243 70.2995C-1.64042 64.6474 1.1772 57.8568 4.39106 52.4484C6.12184 49.5357 7.11573 46.1339 7.11573 42.5C7.11573 38.8952 6.13774 35.5189 4.43261 32.6219C1.25171 27.2174 -1.53017 20.4521 1.22379 14.8181C3.99113 9.15674 10.9743 6.72668 15.6831 10.9144C16.8711 11.9709 17.9992 13.0935 19.0614 14.2764C22.1508 17.7165 24.684 21.6664 26.5193 25.9844L26.5249 25.9974C28.2854 30.1245 32.5276 32.9775 36.9173 32.0468C41.3054 31.1165 44.1635 26.7765 42.6349 22.5594C42.1402 21.1966 41.5955 19.8516 41.0009 18.5293C38.4223 12.795 39.5108 5.71483 44.6403 2.07902Z" fill="#002DE5" />
    <path d="M102.019 26.9762C105.318 26.9762 107.929 28.0939 109.853 30.3294C111.812 32.5304 112.791 35.5225 112.791 39.3055V56.1746H102.689V40.6468C102.689 38.996 102.26 37.7063 101.401 36.7778C100.542 35.8148 99.3904 35.3333 97.9472 35.3333C96.4353 35.3333 95.2499 35.8148 94.3908 36.7778C93.5318 37.7063 93.1023 38.996 93.1023 40.6468V56.1746H83V18H93.1023V31.3611C93.9957 30.0542 95.1983 29.0053 96.7102 28.2143C98.2565 27.3889 100.026 26.9762 102.019 26.9762Z" fill="black" />
    <path d="M145.858 27.2341L127.509 69.9484H116.531L123.437 54.9365L111.583 27.2341H122.819L128.901 43.6389L134.776 27.2341H145.858Z" fill="black" />
    <path d="M156.284 31.2579C157.074 29.9167 158.191 28.8505 159.634 28.0595C161.077 27.2685 162.778 26.873 164.737 26.873C167.039 26.873 169.118 27.4749 170.973 28.6786C172.863 29.8823 174.341 31.6018 175.406 33.8373C176.505 36.0727 177.055 38.6865 177.055 41.6786C177.055 44.6706 176.505 47.3016 175.406 49.5714C174.341 51.8069 172.863 53.5265 170.973 54.7302C169.118 55.9339 167.039 56.5357 164.737 56.5357C162.778 56.5357 161.077 56.1402 159.634 55.3492C158.225 54.5582 157.108 53.4921 156.284 52.1508V70H146.181V27.2341H156.284V31.2579ZM166.798 41.6786C166.798 39.787 166.283 38.3254 165.252 37.2936C164.255 36.2275 163.018 35.6944 161.541 35.6944C160.063 35.6944 158.809 36.2275 157.778 37.2936C156.782 38.3598 156.284 39.8214 156.284 41.6786C156.284 43.5701 156.782 45.0489 157.778 46.1151C158.809 47.1812 160.063 47.7143 161.541 47.7143C163.018 47.7143 164.255 47.1812 165.252 46.1151C166.283 45.0145 166.798 43.5357 166.798 41.6786Z" fill="black" />
    <path d="M207.81 41.369C207.81 42.1601 207.758 42.9511 207.655 43.7421H188.533C188.636 45.3241 189.065 46.5106 189.821 47.3016C190.612 48.0582 191.608 48.4365 192.811 48.4365C194.495 48.4365 195.697 47.6799 196.419 46.1667H207.191C206.744 48.1614 205.868 49.9497 204.562 51.5317C203.291 53.0794 201.676 54.3003 199.718 55.1944C197.759 56.0886 195.594 56.5357 193.223 56.5357C190.371 56.5357 187.828 55.9339 185.595 54.7302C183.396 53.5265 181.661 51.8069 180.389 49.5714C179.152 47.336 178.534 44.705 178.534 41.6786C178.534 38.6521 179.152 36.0384 180.389 33.8373C181.626 31.6018 183.344 29.8823 185.543 28.6786C187.777 27.4749 190.337 26.873 193.223 26.873C196.075 26.873 198.601 27.4577 200.8 28.627C202.999 29.7963 204.717 31.4815 205.954 33.6825C207.191 35.8492 207.81 38.4114 207.81 41.369ZM197.501 38.8413C197.501 37.6032 197.089 36.6402 196.264 35.9524C195.44 35.2302 194.409 34.869 193.172 34.869C191.935 34.869 190.921 35.213 190.131 35.9008C189.34 36.5542 188.825 37.5344 188.584 38.8413H197.501Z" fill="black" />
    <path d="M219.727 32.3413C220.861 30.6905 222.235 29.3836 223.85 28.4206C225.465 27.4577 227.2 26.9762 229.056 26.9762V37.7579H226.221C224.022 37.7579 222.39 38.1878 221.325 39.0476C220.259 39.9074 219.727 41.4034 219.727 43.5357V56.1746H209.624V27.2341H219.727V32.3413Z" fill="black" />
    <path d="M229.997 41.6786C229.997 38.6865 230.616 36.0727 231.853 33.8373C233.09 31.6018 234.808 29.8823 237.007 28.6786C239.241 27.4749 241.783 26.873 244.635 26.873C248.312 26.873 251.404 27.8876 253.913 29.9167C256.421 31.9114 258.036 34.7143 258.758 38.3254H248.037C247.419 36.4339 246.216 35.4881 244.429 35.4881C243.158 35.4881 242.144 36.0212 241.388 37.0873C240.667 38.119 240.306 39.6495 240.306 41.6786C240.306 43.7077 240.667 45.2553 241.388 46.3214C242.144 47.3876 243.158 47.9206 244.429 47.9206C246.25 47.9206 247.453 46.9749 248.037 45.0833H258.758C258.036 48.6601 256.421 51.463 253.913 53.4921C251.404 55.5212 248.312 56.5357 244.635 56.5357C241.783 56.5357 239.241 55.9339 237.007 54.7302C234.808 53.5265 233.09 51.8069 231.853 49.5714C230.616 47.336 229.997 44.705 229.997 41.6786Z" fill="black" />
    <path d="M275.376 56.5357C272.49 56.5357 269.895 55.9339 267.593 54.7302C265.325 53.5265 263.539 51.8069 262.233 49.5714C260.927 47.336 260.274 44.705 260.274 41.6786C260.274 38.6865 260.927 36.0727 262.233 33.8373C263.573 31.6018 265.377 29.8823 267.645 28.6786C269.947 27.4749 272.541 26.873 275.428 26.873C278.314 26.873 280.891 27.4749 283.159 28.6786C285.461 29.8823 287.265 31.6018 288.571 33.8373C289.911 36.0727 290.581 38.6865 290.581 41.6786C290.581 44.6706 289.911 47.3016 288.571 49.5714C287.265 51.8069 285.461 53.5265 283.159 54.7302C280.857 55.9339 278.262 56.5357 275.376 56.5357ZM275.376 47.7659C276.785 47.7659 277.953 47.25 278.881 46.2183C279.843 45.1521 280.324 43.6389 280.324 41.6786C280.324 39.7182 279.843 38.2222 278.881 37.1905C277.953 36.1587 276.802 35.6429 275.428 35.6429C274.053 35.6429 272.902 36.1587 271.974 37.1905C271.047 38.2222 270.583 39.7182 270.583 41.6786C270.583 43.6733 271.029 45.1865 271.923 46.2183C272.816 47.25 273.967 47.7659 275.376 47.7659Z" fill="black" />
    <path d="M292.011 41.6786C292.011 38.6865 292.543 36.0727 293.609 33.8373C294.708 31.6018 296.203 29.8823 298.093 28.6786C299.983 27.4749 302.079 26.873 304.381 26.873C306.237 26.873 307.886 27.2685 309.329 28.0595C310.807 28.8161 311.958 29.8651 312.782 31.2063V18H322.936V56.1746H312.782V52.1508C311.992 53.4921 310.875 54.5582 309.432 55.3492C307.989 56.1402 306.288 56.5357 304.329 56.5357C302.027 56.5357 299.931 55.9339 298.041 54.7302C296.186 53.5265 294.708 51.8069 293.609 49.5714C292.543 47.3016 292.011 44.6706 292.011 41.6786ZM312.834 41.6786C312.834 39.8214 312.319 38.3598 311.288 37.2936C310.291 36.2275 309.054 35.6944 307.577 35.6944C306.065 35.6944 304.811 36.2275 303.814 37.2936C302.818 38.3254 302.319 39.787 302.319 41.6786C302.319 43.5357 302.818 45.0145 303.814 46.1151C304.811 47.1812 306.065 47.7143 307.577 47.7143C309.054 47.7143 310.291 47.1812 311.288 46.1151C312.319 45.0489 312.834 43.5701 312.834 41.6786Z" fill="black" />
    <path d="M354 41.369C354 42.1601 353.948 42.9511 353.845 43.7421H334.723C334.826 45.3241 335.256 46.5106 336.012 47.3016C336.802 48.0582 337.799 48.4365 339.001 48.4365C340.685 48.4365 341.888 47.6799 342.609 46.1667H353.381C352.935 48.1614 352.059 49.9497 350.753 51.5317C349.481 53.0794 347.866 54.3003 345.908 55.1944C343.949 56.0886 341.785 56.5357 339.414 56.5357C336.562 56.5357 334.019 55.9339 331.785 54.7302C329.586 53.5265 327.851 51.8069 326.58 49.5714C325.343 47.336 324.724 44.705 324.724 41.6786C324.724 38.6521 325.343 36.0384 326.58 33.8373C327.817 31.6018 329.535 29.8823 331.734 28.6786C333.967 27.4749 336.527 26.873 339.414 26.873C342.266 26.873 344.791 27.4577 346.99 28.627C349.189 29.7963 350.907 31.4815 352.144 33.6825C353.381 35.8492 354 38.4114 354 41.369ZM343.692 38.8413C343.692 37.6032 343.279 36.6402 342.455 35.9524C341.63 35.2302 340.599 34.869 339.362 34.869C338.125 34.869 337.111 35.213 336.321 35.9008C335.531 36.5542 335.015 37.5344 334.775 38.8413H343.692Z" fill="black" />
</svg>  -->
<img src="{{asset('img/core-img/smpn-3-with-title.png')}}" {!! $attributes !!} alt="" srcset="{{asset('img/core-img/smpn-3-with-title.png')}}"/>

@else

<svg {!! $attributes !!} viewBox="0 0 512 512" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M317.892 12.5231C348.752 -9.35092 391.99 -2.2539 409.376 31.3403C444.196 98.6225 463.864 175.014 463.864 256C463.864 336.986 444.196 413.377 409.376 480.66C391.99 514.254 348.752 521.351 317.892 499.477C286.994 477.577 280.437 434.929 295.97 400.388C299.556 392.413 302.743 384.297 305.812 376.112C315.02 350.71 297.804 324.569 271.373 318.965C244.903 313.353 219.324 330.58 208.74 355.482C197.624 381.631 182.263 405.538 163.518 426.338C156.933 433.645 149.93 440.568 142.548 447.071C114.188 472.049 72.3574 457.404 55.761 423.451C39.1189 389.405 56.0909 348.502 75.4497 315.924C85.875 298.38 91.8618 277.889 91.8618 256C91.8618 234.287 85.9708 213.949 75.7 196.499C56.5397 163.945 39.783 123.194 56.3715 89.2573C73.0407 55.1559 115.104 40.5183 143.467 65.743C150.624 72.1074 157.419 78.8694 163.817 85.9944C182.426 106.716 197.685 130.508 208.74 156.518L208.773 156.596C219.378 181.456 244.931 198.641 271.373 193.035C297.804 187.431 315.02 161.289 305.812 135.887C302.833 127.678 299.552 119.576 295.97 111.612C280.438 77.0712 286.994 34.4235 317.892 12.5231Z" fill="#002DE5" />
</svg>


@endif