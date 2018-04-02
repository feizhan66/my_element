import pickle
# 有问题
# print(dir(pickle))

my_list = [123,951]
pickle_file = open('./pickle.pkl','wb')
pickle.dump(my_list,pickle_file)
pickle_file.close()














