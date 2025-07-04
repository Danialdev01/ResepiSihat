document.addEventListener('DOMContentLoaded', () => {
    let player = new Audio();
    let currentSongIndex = 0;
    let isShuffle = false;
    let originalPlaylist = [];
    let currentPlaylist = [];
    let isPlaying = false;

    // Fetch songs from Cloudinary
    fetch('../../backend/requests/fetchSongs.php')
        .then(response => response.json())
        .then(songs => {
            originalPlaylist = songs;
            currentPlaylist = [...songs];
            populatePlaylist(songs);
        });

    // Playlist population
    function populatePlaylist(songs) {
        const playlist = document.getElementById('playlist');
        playlist.innerHTML = '';

        songs.forEach((song, index) => {
            const songElement = document.createElement('div');
            songElement.className = 'p-2 hover:bg-gray-800 rounded cursor-pointer';
            songElement.innerHTML = `
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-medium">${song.title}</h4>
                    </div>
                </div>
            `;
            
            songElement.addEventListener('click', () => playSong(index));
            playlist.appendChild(songElement);
        });
    }

    // Player controls
    function playSong(index) {
        currentSongIndex = index;
        player.src = currentPlaylist[index].url;
        player.play();
        isPlaying = true;
        updatePlayerUI();
    }

    function updatePlayerUI() {
        const song = currentPlaylist[currentSongIndex];
        document.getElementById('songTitle').textContent = song.title;
        document.getElementById('songArtist').textContent = 'Unknown Artist';
        document.getElementById('nowPlaying').classList.remove('hidden');
        
        // Update play/pause icon
        document.getElementById('playIcon').classList.toggle('hidden', isPlaying);
        document.getElementById('pauseIcon').classList.toggle('hidden', !isPlaying);
    }

    // Event listeners
    document.getElementById('playPauseBtn').addEventListener('click', () => {
        if (isPlaying) {
            player.pause();
        } else {
            player.play();
        }
        isPlaying = !isPlaying;
        updatePlayerUI();
    });

    document.getElementById('nextBtn').addEventListener('click', nextSong);
    document.getElementById('prevBtn').addEventListener('click', prevSong);
    document.getElementById('shuffleBtn').addEventListener('click', toggleShuffle);

    // Player progress
    player.addEventListener('timeupdate', () => {
        const progress = (player.currentTime / player.duration) * 100;
        document.getElementById('progress').style.width = `${progress}%`;
    });

    // Click to seek
    document.querySelector('.bg-gray-700').addEventListener('click', (e) => {
        const rect = e.target.getBoundingClientRect();
        const pos = (e.clientX - rect.left) / rect.width;
        player.currentTime = pos * player.duration;
    });

    // Song ended
    player.addEventListener('ended', nextSong);

    // Shuffle functionality
    function toggleShuffle() {
        isShuffle = !isShuffle;
        document.getElementById('shuffleBtn').classList.toggle('text-green-500', isShuffle);
        
        if (isShuffle) {
            currentPlaylist = [...originalPlaylist].sort(() => Math.random() - 0.5);
        } else {
            currentPlaylist = [...originalPlaylist];
        }
    }

    function nextSong() {
        currentSongIndex = (currentSongIndex + 1) % currentPlaylist.length;
        playSong(currentSongIndex);
    }

    function prevSong() {
        currentSongIndex = (currentSongIndex - 1 + currentPlaylist.length) % currentPlaylist.length;
        playSong(currentSongIndex);
    }
});