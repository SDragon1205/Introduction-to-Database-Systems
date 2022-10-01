#ifndef INDEX_H_
#define INDEX_H_

#include <climits>
#include <fstream>
#include <iostream>
#include <sstream>
#include <vector>

using namespace std;

// BP myIndex
class Node {
	int MAX = 5000;
  bool IS_LEAF;
  int *key, *value, size;
  //Node **ptr;
  friend class Index;

   public:
   	Node **ptr;
   	Node *parent;
  Node();
};

// BP tree
class Index {
	int MAX = 5000;
  Node *root;
  void insertInternal(int, Node *, Node *);

   public:
  Index();
  void display(Node *);
  Index(int num_rows, vector<int> key, vector<int> value);
//  int partition(vector<int> &key, vector<int> &value, int left, int right);
//  void quicksort(vector<int> &key, vector<int> &value, int left, int right);
  void key_query(vector<int> query_keys);
  void range_query(vector<pair<int,int>> query_pairs);
  void destroy(Node *&node);
  void clear_index();
  Node *getRoot();
};

#endif
