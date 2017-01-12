#!/bin/bash


echo "If you are using Linux, make an alias to sed, like 'alias gsed=sed'"

git add .
git -c color.status=false status \
| gsed -n -r -e '1,/Changes to be committed:/ d' \
            -e '1,1 d' \
            -e '/^Untracked files:/,$ d' \
            -e 's/^\s*//' \
            -e '/./p' \
| git commit -F -

git pull && git push

echo "Done!"
