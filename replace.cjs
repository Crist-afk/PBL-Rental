const fs = require('fs');
const file = 'resources/views/admin/profile.blade.php';
let content = fs.readFileSync(file, 'utf8');
const classRegex = /class="([^"]+)"/g;
let matches = 0;
let replaced = 0;
content = content.replace(classRegex, (match, classes) => {
    matches++;
    if (classes.includes('var(--')) {
        console.log("Found:", classes);
        if (!classes.includes('transition-colors') && !classes.includes('transition-all')) {
            replaced++;
            return 'class="' + classes + ' transition-all duration-300 ease-in-out"';
        }
        if (classes.includes('transition-all') && !classes.includes('duration-300')) {
            replaced++;
            return 'class="' + classes + ' duration-300 ease-in-out"';
        }
    }
    return match;
});
console.log('Matches:', matches, 'Replaced:', replaced);
fs.writeFileSync(file, content);
