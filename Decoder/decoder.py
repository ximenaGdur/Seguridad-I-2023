import csv
from hashlib import sha256

def read_passwords(file_name):
  passwords = []
  try:
    with open(file_name, 'r') as file:
      for line in file:
        passwords.append(line.strip())
  except FileNotFoundError:
    print("The file does not exist")
  except IOError:
    print("The file cannot be read")
  return passwords

def read_users(file_name):
  passwords = {}
  try:
    with open(file_name, 'r') as file:
      csv_reader = csv.reader(file, delimiter=';')
      for row in csv_reader:
        if len(row) >= 2:
          passwords[row[0]]= row[1].strip()
  except IOError:
    print("File could not be opened")
  return passwords

def creating_hashes(existing_passwords):
  hashes_map = {}
  for password1 in existing_passwords:
    hashed_password = sha256(password1.encode('utf-8')).hexdigest()
    hashes_map[password1] = hashed_password.strip()
    for password2 in existing_passwords:
      combined_password1 = password1 + password2
      hashed_password2 = sha256(combined_password1.encode('utf-8')).hexdigest()
      hashes_map[password2] = hashed_password2.strip()
      for password3 in existing_passwords:
        combined_password2 = password1 + password2 + password3
        hashed_password3 = sha256(combined_password2.encode('utf-8')).hexdigest()
        hashes_map[password3] = hashed_password3.strip()
  return hashes_map

def comparing_passwords(user_passwords, hashed_passwords):
  print('Comparing hashes:')
  for username in user_passwords.keys():
    for password in hashed_passwords.keys():
      if hashed_passwords[password] == user_passwords[username]:
        print(f'Success for {username} with password {password}:')
        print(f'{hashed_passwords[password]} == {user_passwords[username]}\n')
def main():
  existing_passwords = read_passwords('passwords.txt')
  user_passwords = read_users('users.csv')
  hashed_passwords = creating_hashes(existing_passwords)
  comparing_passwords(user_passwords, hashed_passwords)

if __name__ == '__main__':
  main()
