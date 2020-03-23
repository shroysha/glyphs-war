if [ -z $1 ]; then
  echo "No file specified" && exit 1
fi

cat "$1" | pbcopy
