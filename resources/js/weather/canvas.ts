(async () => {
  const canvas = document.getElementById('weather-canvas') as HTMLCanvasElement | null;
  if (!canvas) {
    alert('no canvas');
    return;
  }

  const ctx = canvas.getContext('2d');
  if (!ctx) {
    alert('no context');
    return;
  }
  ctx.fillStyle = '#000';
  ctx.fillRect(0, 0, canvas.width, canvas.height);
  ctx.stroke();
})();
