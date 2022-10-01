// Searching on a B+ tree in C++
#include <iostream>
#include <string>
#include "utils.h"
#include <chrono>
#include <climits>
#include <fstream>
#include <iostream>
#include <sstream>
#include <vector>
#include "index.h"

using namespace std;

//class Node {
//  int MAX = 5000;
//  bool IS_LEAF;
//  int *key, *value, size;
//  Node **ptr, *parent;//p
//  friend class Index;
//
//   public:
//  Node();
//};
//
//// BP tree
//class Index {
//  int MAX = 5000;
//  Node *root;
//  void insertInternal(int, Node *, Node *);
//  Node *findParent(Node *, Node *);
//
//   public:
//  Index();
//  void display(Node *);
//  Index(int num_rows, vector<int> key, vector<int> value);
//  void key_query(vector<int> query_keys);
//  void range_query(vector<pair<int,int>> query_pairs);
//  void destroy(Node *&cursor);
//  void clear_index();
//  Node *getRoot();
//};

Node::Node() {
  key = new int[MAX];
  value = new int[MAX];
  ptr = new Node *[MAX + 1];
}

Index::Index(){
  root = NULL;
}

// Insert Operation
void Index::insertInternal(int x, Node *cursor, Node *child) {
  if (cursor->size < MAX) {
  	//cout << "ch\n";
    int i = 0;
    while (x > cursor->key[i] && i < cursor->size)
      i++;
    for (int j = cursor->size; j > i; j--) {
      cursor->key[j] = cursor->key[j - 1];
    }
    for (int j = cursor->size + 1; j > i + 1; j--) {
      cursor->ptr[j] = cursor->ptr[j - 1];
    }
    cursor->key[i] = x;
    cursor->size++;
    cursor->ptr[i + 1] = child;
    child->parent = cursor;//p
  } else {
  	//cout << "\ncheck\n";
    Node *newInternal = new Node;
    int virtualKey[MAX + 1];
    Node *virtualPtr[MAX + 2];
    for (int i = 0; i < MAX; i++) {
      virtualKey[i] = cursor->key[i];
    }
    for (int i = 0; i < MAX + 1; i++) {
      virtualPtr[i] = cursor->ptr[i];
    }
    int i = 0, j;
    while (x > virtualKey[i] && i < MAX)
      i++;
    for (int j = MAX + 1; j > i; j--) {
      virtualKey[j] = virtualKey[j - 1];
    }
    virtualKey[i] = x;
    for (int j = MAX + 2; j > i + 1; j--) {
      virtualPtr[j] = virtualPtr[j - 1];
    }
    virtualPtr[i + 1] = child;
    //child->parent = cursor;//p
    newInternal->IS_LEAF = false;
    cursor->size = (MAX + 1) / 2;
    newInternal->size = MAX - (MAX + 1) / 2;
    for (i = 0, j = cursor->size + 1; i < newInternal->size; i++, j++) {
      newInternal->key[i] = virtualKey[j];
    }
    for (i = 0, j = cursor->size + 1; i < newInternal->size + 1; i++, j++) {
      newInternal->ptr[i] = virtualPtr[j];
      newInternal->ptr[i]->parent = newInternal;//p
      	//cout << "parent: " << newInternal->key[0] << ", ch: " << virtualPtr[j]->key[0] << "\n";
    }
    //cout << "111\n";
    if (cursor == root) {
      Node *newRoot = new Node;
      newRoot->key[0] = cursor->key[cursor->size];
      newRoot->ptr[0] = cursor;
      newRoot->ptr[1] = newInternal;
      cursor->parent = newRoot;//p
      newInternal->parent = newRoot;//p
      newRoot->IS_LEAF = false;
      newRoot->size = 1;
      newRoot->parent = NULL;//p
      root = newRoot;
    } else {
      //insertInternal(cursor->key[cursor->size], findParent(root, cursor), newInternal);
      //cout << "222\n";
      //cout << "ch: " << cursor->key[0] << ", pa: " << cursor->parent->key[0] << "\n";
      insertInternal(cursor->key[cursor->size], cursor->parent, newInternal);
    }
  }
  //cout << "3";
}

// Print the tree
void Index::display(Node *cursor) {
  if (cursor != NULL) {
    for (int i = 0; i < cursor->size; i++) {
      cout << cursor->key[i] << " ";
    }
    cout << "\n";
    if (cursor->IS_LEAF != true) {
      for (int i = 0; i < cursor->size + 1; i++) {
        display(cursor->ptr[i]);
      }
    }
  }
}

// Get the root
Node *Index::getRoot() {
  return root;
}

Index::Index(int num_rows, vector<int> key, vector<int> value)
{
	root = new Node;
	root->key[0] = key[0];
	root->IS_LEAF = true;
	root->size = 1;//
	root->value[0] = value[0];
	root->parent = NULL;//p
	
	for(int i = 1; i < num_rows; i++)
	{
		//myIndex.insert(key[i], value[i]);
		int x = key[i], y = value[i];
//		if (root == NULL)
//		{
//			root = new Node;
//	    	root->key[0] = x;
//	    	root->IS_LEAF = true;
//	    	root->size = 1;//
//	    	root->value[0] = y;
//	    	root->parent = NULL;
//	  	}
//	  	else
//		{
    	Node *cursor = root;
    	Node *parent;
    	while (cursor->IS_LEAF == false)
		{
    		parent = cursor;
      		for(int i = 0; i < cursor->size; i++){
        		if(x < cursor->key[i]) {
        		  	cursor = cursor->ptr[i];
        		  	break;
        		}
        		if(i == cursor->size - 1){
          			cursor = cursor->ptr[i + 1];
          			break;
        		}
      		}
    	}
    	if(cursor->size < MAX){
      		int i = 0;
      		while (x > cursor->key[i] && i < cursor->size)
        		i++;
      		for (int j = cursor->size; j > i; j--) {
        		cursor->key[j] = cursor->key[j - 1];//
        		cursor->value[j] = cursor->value[j - 1];
      		}
      		cursor->key[i] = x;//
      		cursor->value[i] = y;
      		cursor->parent = parent;//p
      		cursor->size++;
      		cursor->ptr[cursor->size] = cursor->ptr[cursor->size - 1];
      		cursor->ptr[cursor->size - 1] = NULL;
    	}
    	else
		{
    		Node *newLeaf = new Node;
    		int virtualNode[MAX + 1];//
    		int virtualvalue[MAX + 1];
   		 	for (int i = 0; i < MAX; i++)
			{
    			virtualNode[i] = cursor->key[i];//
    			virtualvalue[i] = cursor->value[i];
    		}
    		int i = 0, j;
    		while (x > virtualNode[i] && i < MAX)
    		{
    			i++;
			}
    		for (int j = MAX; j > i; j--)////////////////////////
			{
    	    	virtualNode[j] = virtualNode[j - 1];//
    	    	virtualvalue[j] = virtualvalue[j - 1];
    	    }
    	  	virtualNode[i] = x;//
    	  	virtualvalue[i] = y;
    	  	newLeaf->IS_LEAF = true;
    	  	cursor->size = (MAX + 1) / 2;
    	  	newLeaf->size = MAX + 1 - cursor->size; //MAX + 1 - (MAX + 1) / 2
    	  	//cout << "left: " << cursor->size << ", right: " <<  newLeaf->size << "\n";
    	  	cursor->ptr[cursor->size] = newLeaf;
    	  	newLeaf->ptr[newLeaf->size] = cursor->ptr[MAX];
    	  	cursor->ptr[MAX] = NULL;
    	  	for (i = 0; i < cursor->size; i++)
			{
    	    	cursor->key[i] = virtualNode[i];//
    	    	cursor->value[i] = virtualvalue[i];
      		}
    	  	//cout << "1";
    	  	for (i = 0, j = cursor->size; i < newLeaf->size; i++, j++)
			{
				//cout << "2";
        		newLeaf->key[i] = virtualNode[j];//
        		//cout << "3";
        		newLeaf->value[i] = virtualvalue[j];
        		//cout << "4";
      		}
      		//cout << "1";
      		if(cursor == root)
			{
        		Node *newRoot = new Node;
        		newRoot->key[0] = newLeaf->key[0];//
        		newRoot->value[0] = newLeaf->value[0];
        		newRoot->ptr[0] = cursor;
       		 	newRoot->ptr[1] = newLeaf;
       		 	cursor->parent = newRoot;//p
       		 	newLeaf->parent = newRoot;//p
        		newRoot->IS_LEAF = false;
        		newRoot->size = 1;
        		root = newRoot;
      		}
			else
			{
        		insertInternal(newLeaf->key[0], parent, newLeaf);
      		}
    	}
//  		}
//		cout << "display\n";
//		display(root);
//		cout << "end\n";
	}
}

void Index::key_query(vector<int> query_keys)
{
	ofstream fout("key_query_out.txt");
	for(vector<int>::iterator it = query_keys.begin(); it != query_keys.end(); it++)
	{
		int x = *it;
		if (root == NULL) {
	    	fout << "-1" << "\n";
	  	}
	  	else {
	    	Node *cursor = root;
	    	while (cursor->IS_LEAF == false) {
	    		for (int i = 0; i < cursor->size; i++) {
	    	    	if (x < cursor->key[i]) {
	    	    		cursor = cursor->ptr[i];
	    	    		break;
	    	    	}
	    	    	if (i == cursor->size - 1) {
	    	      		cursor = cursor->ptr[i + 1];
	    	      		break;
	    	    	}
	    	  	}
	    	}
	    	bool ff = true;
	    	for (int i = 0; i < cursor->size; i++) {
	    	  	if (cursor->key[i] == x) {
	    	    	fout << cursor->value[i] << "\n";
	    	    	ff = false;
	    	    	break;
	      		}
	    	}
	    	if(ff)
	    	{
	    		fout << "-1" << "\n";
			}
	  	}
	}
	fout.close();
}

void Index::range_query(vector<pair<int,int>> query_pairs)
{
	ofstream fout("range_query_out.txt");
	for(vector<pair<int,int>>::iterator it = query_pairs.begin(); it != query_pairs.end(); it++)
	{
		//fout << myIndex.range(it->first, it->second) << "\n";
		int x = it->first, y = it->second;
//		if(root == NULL){
//			fout << "-1\n";
//			continue;
//	  	}
	    Node *cursor = root;
	    Node *parent;
	    while (cursor->IS_LEAF == false)
		{
	    	parent = cursor;
	      	for(int i = 0; i < cursor->size; i++){
	       		if(x <= cursor->key[i]) {
	       		  	cursor = cursor->ptr[i];
	        	  	break;
	        	}
	        	if(i == cursor->size - 1){
	          		cursor = cursor->ptr[i + 1];
	          		break;
	        	}
	      	}
	    }
	    
	    //cout << "check\n";
	    int ans = -2147483648;
	    bool ff = false;
	    while (cursor != NULL && cursor->key[0] <= y)
		{
	    	for(int i = 0; i < cursor->size; i++)
	    	{
	    		if(x <= cursor->key[i] && cursor->key[i] <= y)
	    		{
	    			ans = max(ans, cursor->value[i]);
	    			ff = true;
				}
			}
			cursor = cursor->ptr[cursor->size];
	    }
	    //cout << "check\n";
	    if(ff)
	    {
	    	fout << ans << "\n";
		}
	    else
	    {
	    	fout << "-1\n";
		}
	}
	fout.close();
}

void Index::destroy(Node *&node)
{
	int i;
	if (node->IS_LEAF)
	{
		delete[] node->key;
		delete[] node->value;
		delete[] node->ptr;
	}
  	else
  	{
  		for (i = 0; i < node->size + 1; i++)
  		{
  			//cout << "free: " << node->key[0] << "\n";
  			destroy(node->ptr[i]);
		}
		delete[] node->key;
		delete[] node->ptr;
	}
}

void Index::clear_index()
{
	destroy(root);
}

//int main(){
//	int num_rows = 7;
//	vector<int> key = {0, 10, 20, 30, 40, 50, 60};
//	vector<int> value = {0, 1, 2, 3, 4, 5, 6};
//	vector<int> query_keys = {0, 10, 20, 30, 40, 50, 60, 70};
//	vector<pair<int,int>> query_pairs;
//	//cout <<"-1\n";
//	Index myIndex(num_rows, key, value);
//	//cout <<"1\n";
//	myIndex.key_query(query_keys);
//	query_pairs.push_back(make_pair(0,60));
//	query_pairs.push_back(make_pair(30,60));
//	query_pairs.push_back(make_pair(12,15));
//	query_pairs.push_back(make_pair(40,40));
//	//cout <<"2\n";
//	myIndex.range_query(query_pairs);
//	//cout <<"3\n";
//	myIndex.clear_index();
//	//cout <<"4444444444444444444\n";
//	//cout << "range" << myIndex.range(6, 45) << "\n";
//	//myIndex.display(myIndex.getRoot());
//	
//	return 0;
//}
