import csv
from hashlib import sha256
import threading
from concurrent.futures import ThreadPoolExecutor
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

def creating_hashes(existing_passwords,start, end, hashes_map):
  for i in range(start, end):
    password1 = existing_passwords[i]
    print(i)
    hashed_password = sha256(password1.encode('utf-8')).hexdigest()
    hashes_map[password1] = hashed_password.strip()
    for j in range(len(existing_passwords)):
      password2 = existing_passwords[j]
      combined_password1 = password1 + password2
      hashed_password2 = sha256(combined_password1.encode('utf-8')).hexdigest()
      hashes_map[password2] = hashed_password2.strip()
      for k in range(len(existing_passwords)):
          password3 = existing_passwords[k]
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
  num_threads = 12
  existing_passwords = read_passwords('passwords.txt')
  batch_size = len(existing_passwords) // num_threads
  user_passwords = read_users('users.csv')
  print(len(existing_passwords))
  result_dict = {}
  with ThreadPoolExecutor(max_workers=num_threads) as executor:
    futures = []

    for i in range(num_threads):
      start = i * batch_size
      end = start + batch_size if i < num_threads - 1 else len(existing_passwords)
      future = executor.submit(creating_hashes, existing_passwords, start, end, result_dict)
      futures.append(future)

    # Espera a que todos los hilos terminen
    for future in futures:
      future.result()
  comparing_passwords(user_passwords, result_dict)
  print("Fin") 

if __name__ == '__main__':
  main()
