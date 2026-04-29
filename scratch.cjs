const fs = require('fs');
const file = 'resources/views/admin/profile.blade.php';
let content = fs.readFileSync(file, 'utf8');

const classRegex = /class="([^"]+)"/g;
content = content.replace(classRegex, (match, classes) => {
    if (classes.includes('var(--') && !classes.includes('transition-all') && !classes.includes('transition-colors')) {
        return 'class="' + classes + ' transition-all duration-300 ease-in-out"';
    }
    if (classes.includes('var(--') && classes.includes('transition-all') && !classes.includes('duration-300')) {
        return 'class="' + classes + ' duration-300 ease-in-out"';
    }
    return match;
});

fs.writeFileSync(file, content);
