#------------------------------------
#--Convert Github Markdown to
#--WordPress readme.txt
#--https://pippinsplugins.com/how-to-properly-format-and-enhance-your-plugins-readme-txt-file-for-the-wordpress-org-repository/
#--Images are still a bit hard coded
#------------------------------------

#DELETE EXISTING README IF EXIST
[ -e readme.txt ] && rm readme.txt

#LOOP README.md LINE BY LINE
while read line; do
  
  #REMOVE LINE ENDINGS
  line=${line%$'\n'} 

  #IF SCREENSHOT THEN REPLACE LINE
   if [[ ${line:0:3} = \![1 ]] ;
  then
    line="1. Admin settings page (running with WordPress 4.8 here)";
  fi

  #IF GITHUB BUILD STATUS THEN REMOVE LINE
  if [[ ${line:0:3} = \[![ ]] ;
	then
		continue #SKIP LINE
	fi
  
  #REPLACE ### by = ... =
  if [[ ${line:0:3} = \### ]] ;
  then
    line="= ${line#"### "} =";
  fi

  #REPLACE ## by == ... ==
  if [[ ${line:0:2} = \## ]] ;
  then
    line="== ${line#"## "} ==";
  fi

  #REPLACE # by === ... ===
  if [[ ${line:0:1} = \# ]] ;
  then
    line="=== ${line#"# "} ===";
  fi

  #REPLACE -... by *...
  if [[ ${line:0:1} = - ]] ;
  then
    line="* ${line#"- "}";
  fi

  #APPEND LINE TO README
  echo "$line" >> readme.txt
done <README.md