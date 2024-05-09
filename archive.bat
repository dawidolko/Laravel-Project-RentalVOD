git init
git config --local user.name "project"
git config --local user.email "project@ur.edu.pl"
git add --all
git commit -m "project RentalVOD"
git archive --format=zip HEAD -o ../RentalVOD_archive.zip
pause
